<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransportDocument extends Model
{
    protected $fillable = [
        'workshop_id',
        'document_id',
        'date',
        'notes',
    ];

    public function workshop() : BelongsTo {
        return $this->belongsTo(Workshop::class);
    }

    public function workings() : BelongsToMany {
        return $this->belongsToMany(Working::class);
    }
}
