<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function index()
    {
        $records = MaintenanceRecord::with('asset')->latest()->paginate(10);
        return view('maintenances.index', compact('records'));
    }

    public function create()
    {
        $assets = Asset::orderBy('code')->get();
        return view('maintenances.create', compact('assets'));
    }

    public function store(Request $request)
    {
        MaintenanceRecord::create($this->validated($request));

        return redirect()->route('maintenances.index')->with('success', 'Data pemeliharaan berhasil dicatat.');
    }

    public function complete(MaintenanceRecord $maintenance)
    {
        $maintenance->update(['status' => 'selesai']);

        return redirect()->route('maintenances.index')->with('success', 'Pemeliharaan ditandai selesai.');
    }

    public function edit(MaintenanceRecord $maintenance)
    {
        $assets = Asset::orderBy('code')->get();

        return view('maintenances.edit', compact('maintenance', 'assets'));
    }

    public function update(Request $request, MaintenanceRecord $maintenance)
    {
        $maintenance->update($this->validated($request));

        return redirect()->route('maintenances.index')->with('success', 'Data pemeliharaan berhasil diperbarui.');
    }

    public function destroy(MaintenanceRecord $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('maintenances.index')->with('success', 'Data pemeliharaan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'damage_description' => 'required|string',
            'action_taken' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'maintenance_date' => 'required|date',
            'status' => 'required|in:proses,selesai',
        ]);
    }
}