@extends('layouts.master')
@section('title', 'Data Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Aset</h4>
    <a href="{{ route('assets.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Aset
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('assets.index') }}" class="row g-2">
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
                <button class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                <a href="{{ route('assets.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Penanggung Jawab</th>
                    <th>Kondisi</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets as $asset)
                <tr>
                    <td>{{ $assets->firstItem() + $loop->index }}</td>
                    <td>{{ $asset->code }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->category->name ?? '-' }}</td>
                    <td>{{ $asset->location->name ?? '-' }}</td>
                    <td>{{ $asset->user->name ?? '-' }}</td>
                    <td>
                        @php
                            $badgeColor = match($asset->condition) {
                                'baik' => 'success',
                                'rusak_ringan' => 'warning',
                                'rusak_berat' => 'danger',
                                'hilang' => 'dark',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ str_replace('_', ' ', $asset->condition) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('assets.edit', $asset) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus aset ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">Tidak ada data aset.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $assets->links() }}
    </div>
</div>
@endsection