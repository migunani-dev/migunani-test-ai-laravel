@extends('layout.main')
@section('title', 'Upload Excel')

@section('container')
<h4 class="mb-4">📤 Upload File Excel</h4>

<div class="card">
    <div class="card-body">
        <form action="/transaction/upload" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Platform / Ekspedisi</label>
                <select name="gudang" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="lazada">Lazada</option>
                    <option value="shopee">Shopee</option>
                    <option value="tiktok">TikTok</option>
                    <option value="tokped">Tokopedia</option>
                    <option value="jntAlalak">J&T Alalak</option>
                    <option value="jntPamulang">J&T Pamulang</option>
                    <option value="jntFulfil">J&T Fulfilment</option>
                    <option value="ninjaFulfil">Ninja Fulfilment</option>
                    <option value="ninjaPamulang">Ninja Pamulang</option>
                    <option value="kiriminAja">KiriminAja</option>
                    <option value="jne">JNE / JNT Cargo / Sentral / Lion</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">File Excel (.xlsx / .xls)</label>
                <input type="file" name="formFile" class="form-control" accept=".xlsx,.xls" required>
                <small class="text-muted">Format: header harus sesuai (userId, nama, alamat, dll)</small>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-upload me-1"></i> Upload & Import
            </button>
        </form>
    </div>
</div>
@endsection
