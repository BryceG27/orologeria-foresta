<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Working extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'company_id',
        'working_id',
        'working_status_id',
        'brand_id',
        'reference',
        'acceptance_date',
        'delivery_date',
        'working_description',
        'payment_method_id',
        'total_cost',
        'extra_notes',
    ];

    public function status() : BelongsTo {
        return $this->belongsTo(WorkingStatus::class, 'working_status_id');
    }

    public function customer() : BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function company() : BelongsTo {
        return $this->belongsTo(Customer::class, 'company_id');
    }

    public function brand() : BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function paymentMethod() : BelongsTo {
        return $this->belongsTo(PaymentMethod::class);
    }
}