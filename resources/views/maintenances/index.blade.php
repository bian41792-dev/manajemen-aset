@extends('layouts.master')
@section('title', 'Pemeliharaan Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Pemeliharaan Aset</h4>
    <a href="{{ route('maintenances.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Catat Pemeliharaan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Aset</th>
                    <th>Tanggal</th>
                    <th>Kerusakan</th>
                    <th>Tindakan</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $records->firstItem() + $loop->index }}</td>
                    <td>{{ $record->asset->name ?? '-' }} ({{ $record->asset->code ?? '-' }})</td>
                    <td>{{ \Carbon\Carbon::parse($record->maintenance_date)->format('d M Y') }}</td>
                    <td>{{ $record->damage_description }}</td>
                    <td>{{ $record->action_taken ?? '-' }}</td>
                    <td>{{ $record->cost ? 'Rp ' . number_format($record->cost, 0, ',', '.') : '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $record->status === 'selesai' ? 'success' : 'warning' }}">
                            {{ $record->status }}
                        </span>
                    </td>
                    <td>
                        @if($record->status === 'proses')
                        <form action="{{ route('maintenances.complete', $record) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai pemeliharaan ini selesai?')">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-success" title="Selesai">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('maintenances.edit', $record) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('maintenances.destroy', $record) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pemeliharaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">Belum ada data pemeliharaan.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $records->links() }}
    </div>
</div>
@endsection