@extends('layouts.master')
@section('title', 'Catat Peminjaman')

@section('content')
<h4 class="mb-3">Catat Peminjaman Aset</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Aset (yang tersedia)</label>
                <select name="asset_id" class="form-select @error('asset_id') is-invalid @enderror">
                    <option value="">-- Pilih Aset --</option>
                    @foreach($assets as $asset)
                    <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                        {{ $asset->code }} - {{ $asset->name }}
                    </option>
                    @endforeach
                </select>
                @error('asset_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Peminjam</label>
                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                    <option value="">-- Pilih Peminjam --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="loan_date" class="form-control @error('loan_date') is-invalid @enderror" value="{{ old('loan_date', date('Y-m-d')) }}">
                @error('loan_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
