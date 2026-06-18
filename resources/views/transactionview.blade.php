@extends('layout.main')
@section('title', 'Dashboard')

@section('container')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>📊 Dashboard Transaksi</h4>
    <div>
        <a href="/transaction/export{{ request('cari') ? '?filterExport=1&'.http_build_query(request()->only(['tanggalAwalExport','tanggalAkhirExport','produkExport','transferExport','statusExport','ekspedisiExport','provinsiExport','kotaExport'])) : '' }}"
           class="btn btn-success btn-sm">
            <i class="bi bi-download me-1"></i> Export Excel
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="/" id="filterForm">
            @csrf
            <input type="hidden" name="cari" value="1">
            <div class="row g-2">
                <div class="col-md-2">
                    <input type="date" name="tanggalAwal" class="form-control form-control-sm" value="{{ $filter['tanggalAwal'] ?? '' }}" placeholder="Tgl Awal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="tanggalAkhir" class="form-control form-control-sm" value="{{ $filter['tanggalAkhir'] ?? '' }}" placeholder="Tgl Akhir">
                </div>
                <div class="col-md-2">
                    <input type="text" name="noHp" class="form-control form-control-sm" value="{{ $filter['noHp'] ?? '' }}" placeholder="No HP / Invoice">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="/" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Stats -->
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h5>{{ number_format($transactions->count(), 0, ',', '.') }}</h5>
                <small>Total Transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h5>Rp{{ number_format($transactions->sum('jumlahBayar'), 0, ',', '.') }}</h5>
                <small>Total Pembayaran</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h5>{{ number_format($transactions->sum('vol'), 0, ',', '.') }}</h5>
                <small>Total Volume</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <h5>{{ number_format($transactions->unique('userId')->count(), 0, ',', '.') }}</h5>
                <small>Unique Customer</small>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-striped table-sm mb-0">
                <thead class="table-dark" style="position: sticky; top: 0;">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>No HP</th>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Ekspedisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->tanggal?->format('d/m/Y') }}</td>
                    <td>{{ $t->userId }}</td>
                    <td>{{ $t->nama }}</td>
                    <td>{{ $t->produk }}</td>
                    <td>{{ $t->vol }}</td>
                    <td>Rp{{ number_format($t->jumlahBayar, 0, ',', '.') }}</td>
                    <td>{{ $t->ekspedisi }}</td>
                    <td><span class="badge bg-{{ $t->statusCustomer == 'Lunas' ? 'success' : 'warning' }}">{{ $t->statusCustomer }}</span></td>
                    <td>
                        <a href="/transaction/edit/{{ $t->id }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="/transaction/delete/{{ $t->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center py-4 text-muted">Belum ada data transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
