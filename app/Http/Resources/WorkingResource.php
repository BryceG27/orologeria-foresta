<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingResource extends JsonResource
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
            'working_id' => $this->working_id,
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'reference' => $this->reference,
            'acceptance_date' => $this->acceptance_date,
            'delivery_date' => $this->delivery_date,
            'status' => $this->whenLoaded('status'),
            'working_status_id' => $this->working_status_id,
            'total_cost' => $this->total_cost,
        ];
    }
}
