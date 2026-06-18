<?php

namespace App\Imports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Auth;

class JNTImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private int $rowCount = 0;
    private string $gudang;

    public function __construct(string $gudang = 'jnt')
    {
        $this->gudang = $gudang;
    }

    public function model(array $row)
    {
        $this->rowCount++;
        return new Transaction([
            'userId'        => $row['userid'] ?? $row['no_hp'] ?? $row['phone'] ?? '',
            'nama'          => $row['nama'] ?? $row['name'] ?? $row['customer_name'] ?? '',
            'alamat'        => $row['alamat'] ?? $row['address'] ?? '',
            'provinsi'      => $row['provinsi'] ?? $row['province'] ?? '',
            'kota'          => $row['kota'] ?? $row['city'] ?? '',
            'tanggal'       => $row['tanggal'] ?? $row['date'] ?? now()->toDateString(),
            'noTransaksi'   => $row['no_transaksi'] ?? $row['order_id'] ?? $row['invoice'] ?? '-',
            'produk'        => $row['produk'] ?? $row['product'] ?? $row['item'] ?? '',
            'vol'           => (int) ($row['vol'] ?? $row['qty'] ?? $row['quantity'] ?? 1),
            'harga'         => (int) ($row['harga'] ?? $row['price'] ?? 0),
            'ongkir'        => (int) ($row['ongkir'] ?? $row['shipping'] ?? 0),
            'subsidi'       => (int) ($row['subsidi'] ?? $row['subsidy'] ?? 0),
            'jumlahBayar'   => (int) ($row['jumlah_bayar'] ?? $row['total'] ?? 0),
            'rekening'      => $row['rekening'] ?? $row['bank'] ?? '',
            'ekspedisi'     => $row['ekspedisi'] ?? $row['courier'] ?? '',
            'statusCustomer'=> $row['status_customer'] ?? $row['status'] ?? 'Baru',
            'statusRO'      => $row['status_ro'] ?? $row['statusRO'] ?? null,
            'namaCS'        => $row['nama_cs'] ?? $row['cs'] ?? Auth::user()?->name ?? '',
            'kategoriDivisi'=> $row['kategori_divisi'] ?? $row['division'] ?? null,
            'namaInputter'  => Auth::user()?->name ?? '',
            'gudang'        => $this->gudang,
        ]);
    }

    public function batchSize(): int { return 500; }
    public function chunkSize(): int { return 500; }
    public function getRowCount(): int { return $this->rowCount; }
}
