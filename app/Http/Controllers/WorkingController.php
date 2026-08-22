<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Working;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Workings/Index', [
            'workings' => Working::with(['customer', 'brand', 'status'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Workings/Create', [
            'working' => new Working([
                'working_status_id' => 1
            ]),
            'brands' => Brand::all(),
            'customers' => Customer::all(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Working $working)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Working $working)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Working $working)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Working $working)
    {
        //
    }
}
