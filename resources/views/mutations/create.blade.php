@extends('layouts.master')
@section('title', 'Catat Mutasi Aset')

@section('content')
<h4 class="mb-3">Catat Mutasi Aset</h4>
<div class="card">
    <div class="card-body">
        <form action="{{ route('mutations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih Aset</label>
                <select name="asset_id" class="form-select @error('asset_id') is-invalid @enderror" id="assetSelect">
                    <option value="">-- Pilih Aset --</option>
                    @foreach($assets as $asset)
                    <option value="{{ $asset->id }}"
                        data-location="{{ $asset->location->name ?? '-' }}"
                        data-user="{{ $asset->user->name ?? '-' }}"
                        {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                        {{ $asset->code }} - {{ $asset->name }}
                    </option>
                    @endforeach
                </select>
                @error('asset_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-muted">Lokasi saat ini: <span id="currentLocation">-</span> | Penanggung jawab saat ini: <span id="currentUser">-</span></small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lokasi Baru (Tujuan)</label>
                    <select name="to_location_id" class="form-select @error('to_location_id') is-invalid @enderror">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('to_location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                    @error('to_location_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penanggung Jawab Baru</label>
                    <select name="to_user_id" class="form-select">
                        <option value="">-- Tidak ada --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('to_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Mutasi</label>
                <input type="date" name="mutation_date" class="form-control @error('mutation_date') is-invalid @enderror" value="{{ old('mutation_date', date('Y-m-d')) }}">
                @error('mutation_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alasan Mutasi</label>
                <textarea name="reason" class="form-control" rows="3">{{ old('reason') }}</textarea>
            </div>

            <button class="btn btn-primary">Simpan Mutasi</button>
            <a href="{{ route('mutations.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('assetSelect').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('currentLocation').textContent = selected.dataset.location || '-';
        document.getElementById('currentUser').textContent = selected.dataset.user || '-';
    });
</script>
@endsection
