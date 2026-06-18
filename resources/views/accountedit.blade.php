@extends('layout.main')
@section('title', 'Edit Akun')

@section('container')
<h4 class="mb-4">✏️ Edit Akun: {{ $user->name }}</h4>

<div class="card">
    <div class="card-body">
        <form action="/account/admin/{{ $user->id }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password (kosongkan jika tidak ganti)</label>
                    <input type="password" name="password" class="form-control" minlength="6">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="admin" {{ $user->status == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="inputter" {{ $user->status == 'inputter' ? 'selected' : '' }}>Inputter</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
            <a href="/account/admin" class="btn btn-outline-secondary mt-3">Batal</a>
        </form>
    </div>
</div>
@endsection
