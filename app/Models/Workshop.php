<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Workshop extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'notes',
    ];

    public static function validate(Request $request) {
        return $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'Il nome è obbligatorio.',
            'name.string' => 'Il nome deve essere una stringa.',
            'name.max' => 'Il nome non può superare i 255 caratteri.',
            'address.string' => 'L\'indirizzo deve essere una stringa.',
            'address.max' => 'L\'indirizzo non può superare i 255 caratteri.',
            'phone.string' => 'Il telefono deve essere una stringa.',
            'phone.max' => 'Il telefono non può superare i 255 caratteri.',
            'email.email' => 'L\'email deve essere un indirizzo email valido.',
            'email.max' => 'L\'email non può superare i 255 caratteri.',
        ]);
    }
}
