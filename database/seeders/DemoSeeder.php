<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetLoan;
use App\Models\AssetMutation;
use App\Models\Category;
use App\Models\Location;
use App\Models\MaintenanceRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Penanggung jawab
        $budi = User::firstOrCreate(
            ['email' => 'budi@kreasiputra.test'],
            ['name' => 'Budi Santoso', 'password' => Hash::make('password')]
        );
        $andi = User::firstOrCreate(
            ['email' => 'andi@kreasiputra.test'],
            ['name' => 'Andi Wijaya', 'password' => Hash::make('password')]
        );

        // Kategori
        $cat = [];
        foreach ([
            'Elektronik' => 'Perangkat elektronik kantor',
            'Furnitur' => 'Meja, kursi, dan lemari',
            'Kendaraan' => 'Kendaraan operasional',
            'Peralatan Jaringan' => 'Router, switch, dan kabel',
        ] as $name => $desc) {
            $cat[$name] = Category::firstOrCreate(['name' => $name], ['description' => $desc]);
        }

        // Lokasi
        $loc = [];
        foreach ([
            'Ruang IT' => 'Gedung A',
            'Ruang Administrasi' => 'Gedung A',
            'Ruang Rapat' => 'Gedung B',
            'Gudang' => 'Gedung B',
        ] as $name => $building) {
            $loc[$name] = Location::firstOrCreate(['name' => $name], ['building' => $building]);
        }

        // Aset
        $rows = [
            ['KPH-001', 'Laptop Lenovo ThinkPad', 'Elektronik', 'Ruang Administrasi', $andi, 'baik', '2025-03-10', 12500000],
            ['KPH-002', 'Proyektor Epson', 'Elektronik', 'Ruang Rapat', null, 'baik', '2024-08-15', 7800000],
            ['KPH-003', 'Meja Kerja', 'Furnitur', 'Ruang IT', $budi, 'baik', '2023-01-20', 1500000],
            ['KPH-004', 'Kursi Ergonomis', 'Furnitur', 'Ruang Administrasi', $andi, 'rusak_ringan', '2023-06-05', 950000],
            ['KPH-005', 'Router Mikrotik', 'Peralatan Jaringan', 'Ruang IT', $budi, 'baik', '2024-11-02', 2300000],
            ['KPH-006', 'Mobil Operasional Avanza', 'Kendaraan', 'Gudang', null, 'rusak_berat', '2020-04-12', 210000000],
            ['KPH-007', 'Kamera Mirrorless', 'Elektronik', 'Gudang', null, 'hilang', '2022-09-30', 9500000],
        ];

        $asset = [];
        foreach ($rows as [$code, $name, $category, $location, $user, $condition, $date, $price]) {
            $asset[$code] = Asset::firstOrCreate(['code' => $code], [
                'name' => $name,
                'category_id' => $cat[$category]->id,
                'location_id' => $loc[$location]->id,
                'user_id' => $user?->id,
                'condition' => $condition,
                'purchase_date' => $date,
                'price' => $price,
            ]);
        }

        // Riwayat mutasi: laptop pindah dari Ruang IT (Budi) ke Ruang Administrasi (Andi)
        AssetMutation::firstOrCreate(
            ['asset_id' => $asset['KPH-001']->id, 'mutation_date' => '2026-09-10'],
            [
                'from_location_id' => $loc['Ruang IT']->id,
                'to_location_id' => $loc['Ruang Administrasi']->id,
                'from_user_id' => $budi->id,
                'to_user_id' => $andi->id,
                'reason' => 'Pemindahan pegawai',
            ]
        );

        // Peminjaman: satu masih dipinjam, satu sudah dikembalikan
        AssetLoan::firstOrCreate(
            ['asset_id' => $asset['KPH-002']->id, 'loan_date' => '2026-09-20'],
            ['user_id' => $budi->id, 'status' => 'dipinjam', 'notes' => 'Presentasi ke klien']
        );
        AssetLoan::firstOrCreate(
            ['asset_id' => $asset['KPH-005']->id, 'loan_date' => '2026-09-01'],
            ['user_id' => $andi->id, 'return_date' => '2026-09-05', 'status' => 'dikembalikan', 'notes' => 'Pengujian jaringan']
        );

        // Pemeliharaan: satu selesai, satu masih berjalan
        MaintenanceRecord::firstOrCreate(
            ['asset_id' => $asset['KPH-001']->id, 'maintenance_date' => '2026-09-05'],
            [
                'damage_description' => 'Keyboard tidak berfungsi',
                'action_taken' => 'Penggantian keyboard',
                'cost' => 350000,
                'status' => 'selesai',
            ]
        );
        MaintenanceRecord::firstOrCreate(
            ['asset_id' => $asset['KPH-004']->id, 'maintenance_date' => '2026-09-25'],
            [
                'damage_description' => 'Sandaran kursi longgar',
                'action_taken' => 'Pengencangan dan penggantian baut',
                'cost' => 75000,
                'status' => 'proses',
            ]
        );
    }
}