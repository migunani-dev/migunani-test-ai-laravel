@extends('layout.main')
@section('title', 'Edit Transaksi')

@section('container')
<h4 class="mb-4">✏️ Edit Transaksi #{{ $transaction->id }}</h4>

<form action="/transaction/{{ $transaction->id }}" method="POST">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">No HP</label>
            <input type="text" name="userId" class="form-control" value="{{ $transaction->userId }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $transaction->nama }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">No Transaksi</label>
            <input type="text" name="noTransaksi" class="form-control" value="{{ $transaction->noTransaksi }}" required>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ $transaction->alamat }}</textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $transaction->tanggal?->format('Y-m-d') }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Produk</label>
            <input type="text" name="produk" class="form-control" value="{{ $transaction->produk }}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Volume</label>
            <input type="number" name="vol" class="form-control" value="{{ $transaction->vol }}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $transaction->harga }}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Jumlah Bayar</label>
            <input type="number" name="jumlahBayar" class="form-control" value="{{ $transaction->jumlahBayar }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ekspedisi</label>
            <input type="text" name="ekspedisi" class="form-control" value="{{ $transaction->ekspedisi }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status Customer</label>
            <select name="statusCustomer" class="form-select" required>
                <option value="Baru" {{ $transaction->statusCustomer == 'Baru' ? 'selected' : '' }}>Baru</option>
                <option value="Proses" {{ $transaction->statusCustomer == 'Proses' ? 'selected' : '' }}>Proses</option>
                <option value="Lunas" {{ $transaction->statusCustomer == 'Lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status RO</label>
            <select name="statusRO" class="form-select" required>
                <option value="Ada" {{ $transaction->statusRO == 'Ada' ? 'selected' : '' }}>Ada</option>
                <option value="Tidak" {{ $transaction->statusRO == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                <option value="" {{ !$transaction->statusRO ? 'selected' : '' }}>-</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Gudang</label>
            <input type="text" name="gudang" class="form-control" value="{{ $transaction->gudang }}" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Nama Toko</label>
            <input type="text" name="namaToko" class="form-control" value="{{ $transaction->namaToko }}">
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
