<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $assets = Asset::with(['category', 'location', 'user'])
            ->when($request->search, function ($q, $v) {
                $q->where(function ($w) use ($v) {
                    $w->where('code', 'like', "%{$v}%")->orWhere('name', 'like', "%{$v}%");
                });
            })
            ->when($request->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->when($request->location_id, fn ($q, $v) => $q->where('location_id', $v))
            ->when($request->condition, fn ($q, $v) => $q->where('condition', $v))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('assets.index', compact('assets', 'categories', 'locations'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        $users = User::all();
        $nextCode = $this->generateCode();

        return view('assets.create', compact('categories', 'locations', 'users', 'nextCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:255|unique:assets,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'user_id' => 'nullable|exists:users,id',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'purchase_date' => 'nullable|date',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['code'])) {
            $validated['code'] = $this->generateCode();
        }

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $categories = Category::all();
        $locations = Location::all();
        $users = User::all();

        return view('assets.edit', compact('asset', 'categories', 'locations', 'users'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:assets,code,' . $asset->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'user_id' => 'nullable|exists:users,id',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'purchase_date' => 'nullable|date',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }

    private function generateCode(): string
    {
        // Ambil angka terbesar dari kode berformat KPH-xxx, lalu tambah 1
        $last = Asset::where('code', 'like', 'KPH-%')
            ->orderByRaw('CAST(SUBSTRING(code, 5) AS UNSIGNED) DESC')
            ->value('code');

        $next = $last ? ((int) substr($last, 4)) + 1 : 1;

        return 'KPH-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}