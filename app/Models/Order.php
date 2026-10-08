<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'order_status_id',
        'brand_id',
        'description',
        'notes',
        'order_date',
        'downpayment',
        'total',
    ];

    public static function validate(Request $request) {
        return $request->validate([
            'customer.name' => [Rule::requiredIf($request->customer_id == null)],
            'customer.surname' => [Rule::requiredIf($request->customer_id == null)],
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string',
            'customer_id' => [Rule::requiredIf($request->name == null && $request->surname == null), 'exists:customers,id'],
            'order_status_id' => 'required|exists:order_statuses,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'order_date' => 'nullable|date',
            'downpayment' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
        ], [
            'customer.name.required_if' => 'Il nome è obbligatorio in caso di mancata scelta del cliente.',
            'customer.surname.required_if' => 'Il cognome è obbligatorio in caso di mancata scelta del cliente.',
            'company_name.required_if' => 'La ragione sociale è obbligatoria in caso di mancata scelta del cliente.',
            'customer_id.required_if' => 'La selezione del cliente è obbligatoria se non sono stati forniti nome, cognome e ragione sociale.',
            'customer_id.exists' => 'Il cliente selezionato non esiste.',
            'description.required' => 'La descrizione del prodotto ordinato è obbligatoria.',
        ]);
    }

    public function customer() : BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function status() : BelongsTo {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function payment_status() : BelongsTo {
        return $this->belongsTo(PaymentOrderStatus::class, 'payment_order_status_id');
    }

    public function brand() : BelongsTo {
        return $this->belongsTo(Brand::class);
    }
}
