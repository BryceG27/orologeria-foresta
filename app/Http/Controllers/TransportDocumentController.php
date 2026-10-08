<?php

namespace App\Http\Controllers;

use App\Models\TransportDocument;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('TransportDocuments/Index', [
            'documents' => TransportDocument::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(TransportDocument $transportDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransportDocument $transportDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransportDocument $transportDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransportDocument $transportDocument)
    {
        //
    }
}
