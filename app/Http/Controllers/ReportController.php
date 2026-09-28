<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $assets = $this->filtered($request)->get();
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('reports.index', compact('assets', 'categories', 'locations'));
    }

    public function print(Request $request)
    {
        $assets = $this->filtered($request)->get();

        return view('reports.print', compact('assets'));
    }

    private function filtered(Request $request)
    {
        return Asset::with(['category', 'location', 'user'])
            ->when($request->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->when($request->location_id, fn ($q, $v) => $q->where('location_id', $v))
            ->when($request->condition, fn ($q, $v) => $q->where('condition', $v))
            ->when($request->search, function ($q, $v) {
                $q->where(function ($w) use ($v) {
                    $w->where('code', 'like', "%{$v}%")->orWhere('name', 'like', "%{$v}%");
                });
            })
            ->orderBy('code');
    }
}