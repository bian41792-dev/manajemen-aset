<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aset</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 24px; color: #000; }
        h2, p { margin: 0; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
        .right { text-align: right; }
        .meta { margin-bottom: 8px; }
        .no-print { margin-bottom: 16px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h2>PT KREASI PUTRA HOTAMA</h2>
        <p>Laporan Data Aset</p>
    </div>

    <div class="meta">
        Dicetak: {{ now()->format('d M Y H:i') }} &middot;
        Oleh: {{ auth()->user()->name }} &middot;
        Total: {{ $assets->count() }} aset
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Penanggung Jawab</th>
                <th>Kondisi</th>
                <th class="right">Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset->code }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->category->name ?? '-' }}</td>
                <td>{{ $asset->location->name ?? '-' }}</td>
                <td>{{ $asset->user->name ?? '-' }}</td>
                <td>{{ str_replace('_', ' ', $asset->condition) }}</td>
                <td class="right">{{ $asset->price ? 'Rp ' . number_format($asset->price, 0, ',', '.') : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="right">Total Nilai Aset</th>
                <th class="right">Rp {{ number_format($assets->sum('price'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>