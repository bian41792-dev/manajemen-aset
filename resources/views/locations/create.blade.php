@extends('layouts.master')
@section('title', 'Tambah Lokasi')

@section('content')
<h4 class="mb-3">Tambah Lokasi</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Gedung</label>
                <input type="text" name="building" class="form-control" value="{{ old('building') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lokasi / Ruangan</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('locations.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
