<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'img_path',
    ];

    public static function validate(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|file|image|max:1024',
        ], [
            'name.required' => 'Il nome del marchio è obbligatorio.',
            'logo.image' => 'Il logo deve essere un\'immagine.',
            'logo.max' => 'Il logo non può superare 1 MB.'
        ]);
    }
}
