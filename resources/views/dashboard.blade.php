@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
<h4 class="mb-4">Dashboard</h4>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card text-white bg-primary"><div class="card-body">
            <div class="small">Total Aset</div>
            <div class="fs-3 fw-bold">{{ $totalAssets }}</div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success"><div class="card-body">
            <div class="small">Kondisi Baik</div>
            <div class="fs-3 fw-bold">{{ $goodAssets }}</div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-dark bg-warning"><div class="card-body">
            <div class="small">Rusak</div>
            <div class="fs-3 fw-bold">{{ $damagedAssets }}</div>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-dark"><div class="card-body">
            <div class="small">Hilang</div>
            <div class="fs-3 fw-bold">{{ $lostAssets }}</div>
        </div></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-dark bg-info"><div class="card-body">
            <div class="small">Sedang Dipinjam</div>
            <div class="fs-3 fw-bold">{{ $borrowedAssets }}</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger"><div class="card-body">
            <div class="small">Pemeliharaan Berjalan</div>
            <div class="fs-3 fw-bold">{{ $ongoingMaintenance }}</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-secondary"><div class="card-body">
            <div class="small">Total Nilai Aset</div>
            <div class="fs-3 fw-bold">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
        </div></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="card h-100"><div class="card-body">
            <h6 class="mb-3">Aset per Kategori</h6>
            @forelse($assetsByCategory as $category)
                @php $percent = $totalAssets > 0 ? round($category->assets_count / $totalAssets * 100) : 0; @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between small">
                        <span>{{ $category->name }}</span>
                        <span>{{ $category->assets_count }} aset</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada kategori.</p>
            @endforelse
        </div></div>
    </div>

    <div class="col-md-7">
        <div class="card h-100"><div class="card-body">
            <h6 class="mb-3">Mutasi Terbaru</h6>
            <table class="table table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Dari</th>
                        <th>Ke</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestMutations as $mutation)
                    <tr>
                        <td>{{ $mutation->asset->name ?? '-' }}</td>
                        <td>{{ $mutation->fromLocation->name ?? '-' }}</td>
                        <td>{{ $mutation->toLocation->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($mutation->mutation_date)->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted">Belum ada mutasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6>Aset Terbaru</h6>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestAssets as $asset)
                <tr>
                    <td>{{ $asset->code }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->category->name ?? '-' }}</td>
                    <td>{{ str_replace('_', ' ', $asset->condition) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data aset.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection