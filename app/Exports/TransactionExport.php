<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query ? $this->query->get() : Transaction::all();
    }

    public function headings(): array
    {
        return [
            'User ID', 'Nama', 'Alamat', 'Provinsi', 'Kota', 'Tanggal',
            'No Transaksi', 'Produk', 'Volume', 'Harga', 'Ongkir', 'Subsidi',
            'Jumlah Bayar', 'Rekening', 'Ekspedisi', 'Status Customer', 'Status RO',
            'Promo CRM', 'Nama CS', 'Nama ADV', 'Kategori Divisi', 'Nama Inputter',
            'Gudang', 'Keterangan', 'Nama Toko'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->userId,
            $transaction->nama,
            $transaction->alamat,
            $transaction->provinsi,
            $transaction->kota,
            $transaction->tanggal?->format('Y-m-d'),
            $transaction->noTransaksi,
            $transaction->produk,
            $transaction->vol,
            $transaction->harga,
            $transaction->ongkir,
            $transaction->subsidi,
            $transaction->jumlahBayar,
            $transaction->rekening,
            $transaction->ekspedisi,
            $transaction->statusCustomer,
            $transaction->statusRO,
            $transaction->promoCRM,
            $transaction->namaCS,
            $transaction->namaADV,
            $transaction->kategoriDivisi,
            $transaction->namaInputter,
            $transaction->gudang,
            $transaction->ket,
            $transaction->namaToko,
        ];
    }
}
