@extends('layout.main')
@section('title', 'Manajemen Akun')

@section('container')
<h4 class="mb-4">🔑 Manajemen Akun</h4>

<div class="mb-3">
    <a href="/account/create" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> Tambah Akun</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead class="table-dark">
                <tr><th>#</th><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td><span class="badge bg-secondary">{{ $u->status }}</span></td>
                <td>
                    <a href="/account/admin/{{ $u->id }}/edit" class="btn btn-outline-primary btn-sm">Edit</a>
                    <form action="/account/admin/{{ $u->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
