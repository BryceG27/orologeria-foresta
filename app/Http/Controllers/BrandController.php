<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Brands/Index', [
            'brands' => Brand::withTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Brands/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Brand::validate($request);

        $img_path = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : null;

        Brand::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'img_path' => $img_path,
        ]);

        return redirect()->route('brands.index')->with('success', 'Marchio creato correttamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return Inertia::render('Brands/Edit', [
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = Brand::validate($request);

        $img_path = $request->file('logo') ? $request->file('logo')->store('logos', 'public') : $brand->img_path;

        $brand->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'img_path' => $img_path,
        ]);

        return redirect()->route('brands.index')->with('success', 'Marchio aggiornato correttamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Marchio cancellato correttamente.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(int $brand)
    {
        $brand = Brand::withTrashed()->findOrFail($brand);
        $brand->restore();

        return redirect()->route('brands.index')->with('success', 'Marchio ripristinato correttamente.');
    }
}
