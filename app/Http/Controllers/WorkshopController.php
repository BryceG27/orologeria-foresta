<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Workshops/Index', [
            'workshops' => Workshop::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Workshops/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Workshop::validate($request);

        Workshop::create($data);

        return redirect()->route('workshops.index')->with('success', 'Officina creata con successo');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workshop $workshop)
    {
        return Inertia::render('Workshops/Edit', [
            'workshop' => $workshop,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        $data = Workshop::validate($request);

        $workshop->update($data);

        return redirect()->route('workshops.index')->with('success', 'Officina aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->delete();

        return redirect()->route('workshops.index')->with('success', 'Officina eliminata con successo');
    }
}
