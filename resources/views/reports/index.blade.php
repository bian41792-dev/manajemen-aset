@extends('layouts.master')
@section('title', 'Laporan Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Laporan Aset</h4>
    <a href="{{ route('reports.print', request()->query()) }}" target="_blank" class="btn btn-success">
        <i class="bi bi-printer"></i> Cetak / Simpan PDF
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.index') }}" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari kode / nama" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="location_id" class="form-select">
                    <option value="">Semua Lokasi</option>
                    @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="condition" class="form-select">
                    <option value="">Semua Kondisi</option>
                    @foreach(['baik' => 'Baik', 'rusak_ringan' => 'Rusak Ringan', 'rusak_berat' => 'Rusak Berat', 'hilang' => 'Hilang'] as $value => $label)
                    <option value="{{ $value }}" {{ request('condition') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted mb-2">
            Total {{ $assets->count() }} aset &middot; Nilai Rp {{ number_format($assets->sum('price'), 0, ',', '.') }}
        </p>
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Penanggung Jawab</th>
                    <th>Kondisi</th>
                    <th class="text-end">Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets as $asset)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $asset->code }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->category->name ?? '-' }}</td>
                    <td>{{ $asset->location->name ?? '-' }}</td>
                    <td>{{ $asset->user->name ?? '-' }}</td>
                    <td>{{ str_replace('_', ' ', $asset->condition) }}</td>
                    <td class="text-end">{{ $asset->price ? 'Rp ' . number_format($asset->price, 0, ',', '.') : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">Tidak ada data sesuai filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection