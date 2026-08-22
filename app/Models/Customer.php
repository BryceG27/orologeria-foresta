<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'surname',
        'company_name',
        'email',
        'phone',
        'is_company',
        'active',
        'notes'
    ];

    public static function validate(Request $request) {
        return $request->validate([
            'name' => 'required_if:is_company,false|string|max:255',
            'surname' => 'required_if:is_company,false|string|max:255',
            'company_name' => 'required_if:is_company,true|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'is_company' => 'required|boolean',
            'notes' => 'nullable|string'
        ], [
            'name.required_if' => 'Il campo nome è obbligatorio.',
            'name.string' => 'Il campo nome deve essere una stringa.',
            'name.max' => 'Il campo nome non può superare i 255 caratteri.',
            'surname.required_if' => 'Il campo cognome è obbligatorio.',
            'surname.string' => 'Il campo cognome deve essere una stringa.',
            'surname.max' => 'Il campo cognome non può superare i 255 caratteri.',
            'company_name.required_if' => 'Il campo nome azienda è obbligatorio.',
            'company_name.string' => 'Il campo nome azienda deve essere una stringa.',
            'company_name.max' => 'Il campo nome azienda non può superare i 255 caratteri.',
            'email.email' => 'Il campo email deve essere un indirizzo email valido.',
            'email.max' => 'Il campo email non può superare i 255 caratteri.',
            'phone.string' => 'Il campo telefono deve essere una stringa.',
            'phone.max' => 'Il campo telefono non può superare i 20 caratteri.',
            'is_company.required' => 'Il campo "è un\'azienda" è obbligatorio.',
            'is_company.boolean' => 'Il campo "è un\'azienda" deve essere vero o falso.',
            'notes.string' => 'Il campo note deve essere una stringa.'
        ]);
    }
}
