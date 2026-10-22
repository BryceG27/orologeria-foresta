<?php

namespace App\Http\Controllers;

use App\Models\TransportDocument;
use App\Models\Working;
use App\Models\Workshop;
use Carbon\Carbon;
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
            'documents' => TransportDocument::with(['workings' => fn($query) => $query->with('customer', 'brand'), 'workshop'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TransportDocuments/Create', [
            'document' => new TransportDocument([
                'document_id' => TransportDocument::max('document_id') + 1
            ]),
            'workshops' => Workshop::all(),
            'workings' => Working::where('working_status_id', 1)->with('customer', 'brand')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = TransportDocument::validate($request);
        $data['date'] = Carbon::create($data['date'])->setTimezone('Europe/Rome')->format('Y-m-d H:i:s');

        $transportDocument = TransportDocument::create($data);
        $transportDocument->workings()->sync($data['workings']);

        return redirect()->route('transport-documents.index')->with('message', 'DDT creato con successo');
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
        return Inertia::render('TransportDocuments/Edit', [
            'document' => $transportDocument->load(['workings' => fn($query) => $query->with('customer', 'brand'), 'workshop']),
            'workshops' => Workshop::all(),
            'workings' => Working::where('working_status_id', 1)->with('customer', 'brand')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransportDocument $transportDocument)
    {
        $data = TransportDocument::validate($request);
        $data['date'] = Carbon::create($data['date'])->setTimezone('Europe/Rome')->format('Y-m-d H:i:s');

        $transportDocument->update($data);
        $transportDocument->workings()->sync($data['workings']);

        return redirect()->route('transport-documents.index')->with('message', 'DDT aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransportDocument $transportDocument)
    {
        $transportDocument->delete();
        return redirect()->route('transport-documents.index')->with('message', 'DDT eliminato con successo');
    }
}
