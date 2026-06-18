<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Imports\EtcImport;
use App\Imports\JNTImport;
use App\Imports\KiriminImport;
use App\Imports\LazadaImport;
use App\Imports\MultiImport;
use App\Imports\NinjaImport;
use App\Imports\ShopeeImport;
use App\Imports\TiktokImport;
use App\Imports\TransactionImport;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Peta platform → import handler.
     */
    private array $importers = [];

    public function __construct()
    {
        $this->importers = [
            'lazada'       => [LazadaImport::class, 'Lazada'],
            'shopee'       => [ShopeeImport::class, 'Shopee'],
            'tiktok'       => [TiktokImport::class, 'TikTok'],
            'tokped'       => [MultiImport::class, 'Tokopedia'],
            'jntAlalak'    => [JNTImport::class, 'J&T Alalak'],
            'jntPamulang'  => [JNTImport::class, 'J&T Pamulang'],
            'jntFulfil'    => [JNTImport::class, 'J&T Fulfilment'],
            'ninjaFulfil'  => [NinjaImport::class, 'Ninja Fulfilment'],
            'ninjaPamulang'=> [NinjaImport::class, 'Ninja Pamulang'],
            'kiriminAja'   => [KiriminImport::class, 'KiriminAja'],
            'jne'          => [EtcImport::class, 'JNE / JNT Cargo / Sentral / Lion'],
        ];
    }

    /**
     * Tampilkan daftar transaksi dengan filter.
     */
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Role-based: inputter hanya lihat data sendiri
        if (strtolower(auth()->user()->status ?? '') === 'inputter') {
            $query->where('namaInputter', auth()->user()->name);
        }

        // Filtering
        if ($request->filled('cari')) {
            $query->when($request->tanggalAwal && $request->tanggalAkhir, fn($q) =>
                $q->whereBetween('tanggal', [$request->tanggalAwal, $request->tanggalAkhir])
            );
            $query->when($request->produk, fn($q) => $q->whereIn('produk', (array) $request->produk));
            $query->when($request->transfer, fn($q) => $q->whereIn('rekening', (array) $request->transfer));
            $query->when($request->status, fn($q) => $q->whereIn('statusCustomer', (array) $request->status));
            $query->when($request->statusRo, fn($q) => $q->where('statusRO', $request->statusRo));
            $query->when($request->ekspedisi, fn($q) => $q->whereIn('ekspedisi', (array) $request->ekspedisi));
            $query->when($request->provinsi, fn($q) => $q->whereIn('provinsi', (array) $request->provinsi));
            $query->when($request->kota, fn($q) => $q->whereIn('kota', (array) $request->kota));
            $query->when($request->kategoriDivisi, fn($q) => $q->whereIn('kategoriDivisi', (array) $request->kategoriDivisi));
            $query->when($request->noHp, fn($q) =>
                $q->where('userId', $request->noHp)->orWhere('noTransaksi', $request->noHp)
            );
            $query->when($request->namaToko, fn($q) => $q->where('namaToko', $request->namaToko));
        }

        $transactions = $query->latest()->get();

        return view('transactionview', [
            'transactions'   => $transactions,
            'products'       => Transaction::distinct()->pluck('produk'),
            'transfer'       => Transaction::distinct()->pluck('rekening'),
            'statusCustomer' => Transaction::distinct()->pluck('statusCustomer'),
            'ekspedisi'      => Transaction::distinct()->pluck('ekspedisi'),
            'provinsi'       => Transaction::distinct()->pluck('provinsi'),
            'kota'           => Transaction::distinct()->pluck('kota'),
            'noHp'           => Transaction::distinct()->pluck('userId'),
            'gudang'         => Transaction::distinct()->pluck('gudang'),
            'inputter'       => Transaction::distinct()->pluck('namaInputter'),
            'adv'            => Transaction::distinct()->pluck('namaADV'),
            'cs'             => Transaction::distinct()->pluck('namaCS'),
            'divisi'         => Transaction::distinct()->pluck('kategoriDivisi'),
            'namaToko'       => Transaction::distinct()->pluck('namaToko'),
            'filter'         => $request->only([
                'tanggalAwal','tanggalAkhir','produk','transfer','status',
                'statusRo','ekspedisi','provinsi','kota','noHp','kategoriDivisi','namaToko'
            ]),
        ]);
    }

    /**
     * Form tambah transaksi.
     */
    public function create(Request $request)
    {
        return view('transactioninput', [
            'customerId'       => $request->session()->get('customerId'),
            'customerName'     => $request->session()->get('customerName'),
            'customerAddress'  => $request->session()->get('customerAddress'),
            'customerProvince' => $request->session()->get('customerProvince'),
            'customerCity'     => $request->session()->get('customerCity'),
        ]);
    }

    /**
     * Simpan transaksi baru.
     */
    public function store(Request $request)
    {
        $rules = [
            'userId'         => 'required',
            'nama'           => 'required',
            'alamat'         => 'required',
            'hiddenValue'    => 'required',
            'kota'           => 'required',
            'tanggal'        => 'required|date',
            'noTransaksi'    => 'required',
            'produk'         => 'required',
            'vol'            => 'required|integer',
            'harga'          => 'required|integer',
            'ongkir'         => 'required|integer',
            'subsidi'        => 'required|integer',
            'jumlahBayar'    => 'required|integer',
            'ekspedisi'      => 'required',
            'rekening'       => 'required',
            'statusCustomer' => 'required',
            'statusRO'       => 'required',
            'namaCS'         => 'required',
            'namaADV'        => 'required',
        ];

        if ($request->input('idType') === 'hp') {
            $rules['userId'] = 'required|starts_with:82';
        }

        $validated = $request->validate($rules);
        $validated['provinsi'] = $validated['hiddenValue'];

        Transaction::create($validated);

        return redirect('/')->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Form edit transaksi.
     */
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactionedit', compact('transaction'));
    }

    /**
     * Update transaksi.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return redirect('/')->with('success', 'Transaksi berhasil diupdate.');
    }

    /**
     * Hapus transaksi.
     */
    public function delete($id)
    {
        Transaction::destroy($id);
        return redirect('/')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Halaman upload.
     */
    public function upload()
    {
        return view('transactionupload');
    }

    /**
     * Import Excel — strategy pattern, tanpa if/else panjang.
     */
    public function import(Request $request)
    {
        $platform = $request->input('gudang');

        if (!isset($this->importers[$platform])) {
            // Generic import
            try {
                $importer = new TransactionImport();
                Excel::import($importer, $request->file('formFile'));
                return redirect()->back()->with('success', $importer->getRowCount() . ' Data berhasil diimport.');
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                return redirect()->back()->with('fail', count($e->failures()));
            }
        }

        [$class, $label] = $this->importers[$platform];

        try {
            $importer = str_contains($platform, 'jnt') || str_contains($platform, 'ninja')
                ? new $class($label)
                : new $class();

            Excel::import($importer, $request->file('formFile'));
            $count = method_exists($importer, 'getRowCount') ? $importer->getRowCount() : '?';
            return redirect()->back()->with('success', "$count Data ($label) berhasil diimport.");
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return redirect()->back()->with('fail', count($e->failures()));
        }
    }

    /**
     * Export transaksi ke Excel.
     */
    public function export(Request $request)
    {
        $filename = 'transactions_' . Carbon::now('Asia/Jakarta')->format('Ymd_His') . '.xlsx';

        if ($request->filled('filterExport')) {
            $query = Transaction::query();

            $query->when($request->tanggalAwalExport && $request->tanggalAkhirExport, fn($q) =>
                $q->whereBetween('tanggal', [$request->tanggalAwalExport, $request->tanggalAkhirExport])
            );
            $query->when($request->produkExport, fn($q) => $q->whereIn('produk', (array) $request->produkExport));
            $query->when($request->transferExport, fn($q) => $q->whereIn('rekening', (array) $request->transferExport));
            $query->when($request->statusExport, fn($q) => $q->whereIn('statusCustomer', (array) $request->statusExport));
            $query->when($request->statusRoExport, fn($q) => $q->where('statusRO', $request->statusRoExport));
            $query->when($request->ekspedisiExport, fn($q) => $q->whereIn('ekspedisi', (array) $request->ekspedisiExport));
            $query->when($request->provinsiExport, fn($q) => $q->whereIn('provinsi', (array) $request->provinsiExport));
            $query->when($request->kotaExport, fn($q) => $q->whereIn('kota', (array) $request->kotaExport));
            $query->when($request->noHpExport, fn($q) =>
                $q->where('userId', $request->noHpExport)->orWhere('noTransaksi', $request->noHpExport)
            );

            return Excel::download(new TransactionExport($query), $filename);
        }

        return Excel::download(new TransactionExport(), $filename);
    }
}
