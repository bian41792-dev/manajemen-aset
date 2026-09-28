@extends('layouts.master')
@section('title', 'Edit Peminjaman')

@section('content')
<h4 class="mb-3">Edit Peminjaman</h4>
<div class="card">
    <div class="card-body">
        <div class="alert alert-secondary">
            <strong>Aset:</strong> {{ $loan->asset->code ?? '-' }} - {{ $loan->asset->name ?? '-' }}
        </div>

        <form action="{{ route('loans.update', $loan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Peminjam</label>
                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $loan->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="loan_date" class="form-control @error('loan_date') is-invalid @enderror" value="{{ old('loan_date', \Carbon\Carbon::parse($loan->loan_date)->format('Y-m-d')) }}">
                    @error('loan_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="return_date" class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date', $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('Y-m-d') : '') }}">
                    @error('return_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="dipinjam" {{ old('status', $loan->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ old('status', $loan->status) == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $loan->notes) }}</textarea>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection