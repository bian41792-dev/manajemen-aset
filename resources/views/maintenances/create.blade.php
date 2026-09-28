@extends('layouts.master')
@section('title', 'Catat Pemeliharaan')

@section('content')
<h4 class="mb-3">Catat Pemeliharaan Aset</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('maintenances.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Aset</label>
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
                <label class="form-label">Deskripsi Kerusakan</label>
                <textarea name="damage_description" class="form-control @error('damage_description') is-invalid @enderror" rows="3">{{ old('damage_description') }}</textarea>
                @error('damage_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tindakan yang Dilakukan</label>
                <textarea name="action_taken" class="form-control" rows="3">{{ old('action_taken') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="maintenance_date" class="form-control @error('maintenance_date') is-invalid @enderror" value="{{ old('maintenance_date', date('Y-m-d')) }}">
                    @error('maintenance_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Biaya (Rp)</label>
                    <input type="number" name="cost" class="form-control" value="{{ old('cost') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
