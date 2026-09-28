@extends('layouts.master')
@section('title', 'Edit Mutasi')

@section('content')
<h4 class="mb-3">Edit Mutasi Aset</h4>
<div class="card">
    <div class="card-body">
        <div class="alert alert-secondary">
            <div><strong>Aset:</strong> {{ $mutation->asset->code ?? '-' }} - {{ $mutation->asset->name ?? '-' }}</div>
            <div><strong>Lokasi:</strong> {{ $mutation->fromLocation->name ?? '-' }} &rarr; {{ $mutation->toLocation->name ?? '-' }}</div>
            <div><strong>Penanggung jawab:</strong> {{ $mutation->fromUser->name ?? '-' }} &rarr; {{ $mutation->toUser->name ?? '-' }}</div>
            <small class="text-muted">Lokasi dan penanggung jawab tidak dapat diubah agar riwayat tetap sesuai kondisi aset. Untuk memindahkan lagi, catat mutasi baru.</small>
        </div>

        <form action="{{ route('mutations.update', $mutation) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Tanggal Mutasi</label>
                <input type="date" name="mutation_date" class="form-control @error('mutation_date') is-invalid @enderror" value="{{ old('mutation_date', \Carbon\Carbon::parse($mutation->mutation_date)->format('Y-m-d')) }}">
                @error('mutation_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Alasan Mutasi</label>
                <textarea name="reason" class="form-control" rows="3">{{ old('reason', $mutation->reason) }}</textarea>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('mutations.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection