<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkingStatus extends Model
{
    public function workings() : HasMany {
        return $this->hasMany(Working::class);
    }
}
