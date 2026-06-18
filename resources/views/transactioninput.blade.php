@extends('layout.main')
@section('title', 'Input Transaksi')

@section('container')
<h4 class="mb-4">📝 Input Transaksi Baru</h4>

<!-- Customer Search -->
<div class="card mb-4">
    <div class="card-body">
        <form action="/" method="POST">
            @csrf
            <label class="form-label">Cari Customer (No HP)</label>
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="62812xxxxxx" required>
                <button class="btn btn-outline-primary">Cari</button>
            </div>
        </form>
    </div>
</div>

<form action="/transaction" method="POST">
    @csrf
    <input type="hidden" name="idType" value="hp">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">No HP</label>
            <input type="text" name="userId" class="form-control" value="{{ session('customerId') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ session('customerName') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">No Transaksi</label>
            <input type="text" name="noTransaksi" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ session('customerAddress') }}</textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">Provinsi</label>
            <input type="text" name="hiddenValue" class="form-control" value="{{ session('customerProvince') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Kota</label>
            <input type="text" name="kota" class="form-control" value="{{ session('customerCity') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ekspedisi</label>
            <input type="text" name="ekspedisi" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Produk</label>
            <input type="text" name="produk" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Volume</label>
            <input type="number" name="vol" class="form-control" value="1" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Ongkir</label>
            <input type="number" name="ongkir" class="form-control" value="0">
        </div>
        <div class="col-md-2">
            <label class="form-label">Subsidi</label>
            <input type="number" name="subsidi" class="form-control" value="0">
        </div>
        <div class="col-md-3">
            <label class="form-label">Jumlah Bayar</label>
            <input type="number" name="jumlahBayar" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Rekening</label>
            <input type="text" name="rekening" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status Customer</label>
            <select name="statusCustomer" class="form-select" required>
                <option value="Baru">Baru</option><option value="Proses">Proses</option><option value="Lunas">Lunas</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status RO</label>
            <select name="statusRO" class="form-select" required>
                <option value="Ada">Ada</option><option value="Tidak">Tidak</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nama CS</label>
            <input type="text" name="namaCS" class="form-control" value="{{ auth()->user()->name }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nama ADV</label>
            <input type="text" name="namaADV" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Gudang</label>
            <input type="text" name="gudang" class="form-control" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-4">Simpan Transaksi</button>
</form>
@endsection
