@extends('layouts.master')
@section('title', 'Peminjaman Aset')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Peminjaman Aset</h4>
    <a href="{{ route('loans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Catat Peminjaman
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Aset</th>
                    <th>Peminjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loan->asset->name ?? '-' }} ({{ $loan->asset->code ?? '-' }})</td>
                    <td>{{ $loan->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                    <td>{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d M Y') : '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $loan->status === 'dipinjam' ? 'warning' : 'success' }}">
                            {{ $loan->status }}
                        </span>
                    </td>
                    <td>{{ $loan->notes ?? '-' }}</td>
                    <td>
                        @if($loan->status === 'dipinjam')
                        <form action="{{ route('loans.return', $loan) }}" method="POST" onsubmit="return confirm('Tandai aset ini sudah dikembalikan?')">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-success">
                                <i class="bi bi-arrow-return-left"></i> Kembalikan
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $loans->links() }}
    </div>
</div>
@endsection
