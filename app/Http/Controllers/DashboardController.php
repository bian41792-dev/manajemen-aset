<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetLoan;
use App\Models\AssetMutation;
use App\Models\Category;
use App\Models\MaintenanceRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $goodAssets = Asset::where('condition', 'baik')->count();
        $damagedAssets = Asset::whereIn('condition', ['rusak_ringan', 'rusak_berat'])->count();
        $lostAssets = Asset::where('condition', 'hilang')->count();
        $totalValue = Asset::sum('price');

        $borrowedAssets = AssetLoan::where('status', 'dipinjam')->count();
        $ongoingMaintenance = MaintenanceRecord::where('status', 'proses')->count();

        $assetsByCategory = Category::withCount('assets')->orderByDesc('assets_count')->get();
        $latestMutations = AssetMutation::with(['asset', 'fromLocation', 'toLocation'])->latest()->take(5)->get();
        $latestAssets = Asset::with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalAssets', 'goodAssets', 'damagedAssets', 'lostAssets', 'totalValue',
            'borrowedAssets', 'ongoingMaintenance',
            'assetsByCategory', 'latestMutations', 'latestAssets'
        ));
    }
}