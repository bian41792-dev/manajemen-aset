@extends('layouts.master')
@section('title', 'Lokasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Lokasi</h4>
    <a href="{{ route('locations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Lokasi
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gedung</th>
                    <th>Nama Lokasi</th>
                    <th>Deskripsi</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $location)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $location->building ?? '-' }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada data lokasi.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $locations->links() }}
    </div>
</div>
@endsection
