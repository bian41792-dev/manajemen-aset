<?php

namespace App\Http\Controllers;

use App\Models\AssetMutation;
use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetMutationController extends Controller
{
    public function index()
    {
        $mutations = AssetMutation::with(['asset', 'fromLocation', 'toLocation', 'fromUser', 'toUser'])
            ->latest()
            ->paginate(10);

        return view('mutations.index', compact('mutations'));
    }

    public function create()
    {
        $assets = Asset::with(['location', 'user'])->orderBy('code')->get();
        $locations = Location::all();
        $users = User::all();

        return view('mutations.create', compact('assets', 'locations', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'to_location_id' => 'required|exists:locations,id',
            'to_user_id' => 'nullable|exists:users,id',
            'mutation_date' => 'required|date',
            'reason' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $asset = Asset::findOrFail($validated['asset_id']);

            AssetMutation::create([
                'asset_id' => $asset->id,
                'from_location_id' => $asset->location_id,
                'to_location_id' => $validated['to_location_id'],
                'from_user_id' => $asset->user_id,
                'to_user_id' => $validated['to_user_id'] ?? null,
                'mutation_date' => $validated['mutation_date'],
                'reason' => $validated['reason'] ?? null,
            ]);

            $asset->update([
                'location_id' => $validated['to_location_id'],
                'user_id' => $validated['to_user_id'] ?? null,
            ]);
        });

        return redirect()->route('mutations.index')->with('success', 'Mutasi aset berhasil dicatat.');
    }

    public function edit(AssetMutation $mutation)
    {
        $mutation->load(['asset', 'fromLocation', 'toLocation', 'fromUser', 'toUser']);

        return view('mutations.edit', compact('mutation'));
    }

    public function update(Request $request, AssetMutation $mutation)
    {
        $validated = $request->validate([
            'mutation_date' => 'required|date',
            'reason' => 'nullable|string',
        ]);

        $mutation->update($validated);

        return redirect()->route('mutations.index')->with('success', 'Data mutasi berhasil diperbarui.');
    }

    public function destroy(AssetMutation $mutation)
    {
        $latestId = AssetMutation::where('asset_id', $mutation->asset_id)->max('id');

        if ($mutation->id !== (int) $latestId) {
            return redirect()->route('mutations.index')
                ->with('error', 'Hanya mutasi terbaru dari sebuah aset yang dapat dihapus.');
        }

        DB::transaction(function () use ($mutation) {
            // Kembalikan aset ke lokasi dan penanggung jawab sebelum mutasi
            $asset = $mutation->asset;
            $asset->update([
                'location_id' => $mutation->from_location_id ?? $asset->location_id,
                'user_id' => $mutation->from_user_id,
            ]);

            $mutation->delete();
        });

        return redirect()->route('mutations.index')
            ->with('success', 'Mutasi dihapus dan aset dikembalikan ke lokasi sebelumnya.');
    }
}