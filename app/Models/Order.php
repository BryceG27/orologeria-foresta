<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'order_status_id',
        'brand_id',
        'description',
        'order_date',
        'downpayment',
        'total',
    ];

    public static function validate(Request $request) {
        return $request->validate([
            'name' => [Rule::required_if($request->customer_id == null && $request->company_name == null)],
            'surname' => [Rule::required_if($request->customer_id == null && $request->company_name == null)],
            'company_name' => [Rule::required_if($request->customer_id == null && ($request->name == null || $request->surname == null))],
            'customer_id' => [Rule::requiredIf($request->name == null && $request->surname == null && $request->company_name == null), 'exists:customers,id'],
            'order_status_id' => 'required|exists:order_statuses,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'order_date' => 'nullable|date',
            'downpayment' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
        ], [
            'name.required_if' => 'Il nome è obbligatorio in caso di mancata scelta del cliente.',
            'surname.required_if' => 'Il cognome è obbligatorio in caso di mancata scelta del cliente.',
            'company_name.required_if' => 'La ragione sociale è obbligatoria in caso di mancata scelta del cliente.',
            'customer_id.required_if' => 'La selezione del cliente è obbligatoria se non sono stati forniti nome, cognome e ragione sociale.',
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
