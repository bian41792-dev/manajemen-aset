<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetLoan;
use App\Models\User;
use Illuminate\Http\Request;

class AssetLoanController extends Controller
{
    public function index()
    {
        $loans = AssetLoan::with(['asset', 'user'])->latest()->paginate(10);
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $borrowedIds = AssetLoan::where('status', 'dipinjam')->pluck('asset_id');
        $assets = Asset::whereNotIn('id', $borrowedIds)
            ->where('condition', '!=', 'hilang')
            ->get();
        $users = User::all();

        return view('loans.create', compact('assets', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $alreadyBorrowed = AssetLoan::where('asset_id', $validated['asset_id'])
            ->where('status', 'dipinjam')
            ->exists();

        if ($alreadyBorrowed) {
            return back()
                ->withErrors(['asset_id' => 'Aset ini sedang dipinjam.'])
                ->withInput();
        }

        AssetLoan::create($validated + ['status' => 'dipinjam']);

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function returnLoan(AssetLoan $loan)
    {
        $loan->update([
            'status' => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        return redirect()->route('loans.index')->with('success', 'Aset berhasil dikembalikan.');
    }

    public function edit(AssetLoan $loan)
    {
        $loan->load('asset');
        $users = User::orderBy('name')->get();

        return view('loans.edit', compact('loan', 'users'));
    }

    public function update(Request $request, AssetLoan $loan)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|in:dipinjam,dikembalikan',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'dipinjam') {
            $conflict = AssetLoan::where('asset_id', $loan->asset_id)
                ->where('status', 'dipinjam')
                ->where('id', '!=', $loan->id)
                ->exists();

            if ($conflict) {
                return back()
                    ->withErrors(['status' => 'Aset ini sudah tercatat sedang dipinjam pada peminjaman lain.'])
                    ->withInput();
            }

            $validated['return_date'] = null;
        } elseif (empty($validated['return_date'])) {
            $validated['return_date'] = now()->toDateString();
        }

        $loan->update($validated);

        return redirect()->route('loans.index')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(AssetLoan $loan)
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}