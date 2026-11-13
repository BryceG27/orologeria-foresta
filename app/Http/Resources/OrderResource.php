<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'reference' => $this->reference,
            'acceptance_date' => $this->acceptance_date,
            'delivery_date' => $this->delivery_date,
            'status' => $this->whenLoaded('status'),
            'order_status_id' => $this->order_status_id,
            'total_cost' => $this->total_cost,
        ];
    }
}
