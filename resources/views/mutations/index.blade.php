@extends('layouts.master')
@section('title', 'Mutasi Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Riwayat Mutasi Aset</h4>
    <a href="{{ route('mutations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Catat Mutasi
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Aset</th>
                    <th>Dari Lokasi</th>
                    <th>Ke Lokasi</th>
                    <th>Dari PJ</th>
                    <th>Ke PJ</th>
                    <th>Tanggal</th>
                    <th>Alasan</th>
                    <th width="110">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mutations as $mutation)
                <tr>
                    <td>{{ $mutations->firstItem() + $loop->index }}</td>
                    <td>{{ $mutation->asset->name ?? '-' }} ({{ $mutation->asset->code ?? '-' }})</td>
                    <td>{{ $mutation->fromLocation->name ?? '-' }}</td>
                    <td>{{ $mutation->toLocation->name ?? '-' }}</td>
                    <td>{{ $mutation->fromUser->name ?? '-' }}</td>
                    <td>{{ $mutation->toUser->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($mutation->mutation_date)->format('d M Y') }}</td>
                    <td>{{ $mutation->reason ?? '-' }}</td>
                    <td>
                        <a href="{{ route('mutations.edit', $mutation) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('mutations.destroy', $mutation) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus mutasi ini? Aset akan dikembalikan ke lokasi sebelumnya.')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted">Belum ada riwayat mutasi.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $mutations->links() }}
    </div>
</div>
@endsection