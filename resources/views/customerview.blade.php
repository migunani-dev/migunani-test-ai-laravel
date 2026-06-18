@extends('layout.main')
@section('title', 'Customer')

@section('container')
<h4 class="mb-4">👥 Data Customer</h4>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header">Tambah Customer</div>
            <div class="card-body">
                <form action="/customer" method="POST">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="userId" class="form-control form-control-sm" placeholder="No HP" required>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama" required>
                    </div>
                    <div class="mb-2">
                        <textarea name="alamat" class="form-control form-control-sm" rows="2" placeholder="Alamat" required></textarea>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-6"><input type="text" name="provinsi" class="form-control form-control-sm" placeholder="Provinsi" required></div>
                        <div class="col-6"><input type="text" name="kota" class="form-control form-control-sm" placeholder="Kota" required></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">Daftar Customer</div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>No HP</th><th>Nama</th><th>Kota</th><th>Provinsi</th></tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $c)
                    <tr>
                        <td>{{ $c->userId }}</td>
                        <td>{{ $c->nama }}</td>
                        <td>{{ $c->kota }}</td>
                        <td>{{ $c->provinsi }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
