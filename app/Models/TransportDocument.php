<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class TransportDocument extends Model
{
    protected $fillable = [
        'workshop_id',
        'document_id',
        'date',
        'notes',
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    public function workings(): BelongsToMany
    {
        return $this->belongsToMany(Working::class);
    }

    public static function validate(Request $request)
    {
        return $request->validate([
            'workshop_id' => 'required|exists:workshops,id',
            'workings' => 'required|array',
            'workings.*' => 'exists:workings,id',
            'document_id' => 'required|integer',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
    }
}
