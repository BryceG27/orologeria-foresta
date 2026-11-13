<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class CustomerResource extends JsonResource
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
            'name' => $this->when(!$this->is_company, $this->name),
            'surname' => $this->when(!$this->is_company, $this->surname),
            $this->mergeWhen($this->is_company, [
                'company_name' => $this->company_name,
                'is_company' => boolval($this->is_company),
                'custom_working_id' => $this->when($this->is_company, $this->custom_working_id),
            ]),
            'description' => $this->is_company ? $this->company_name : "{$this->name} {$this->surname}",
            'email' => $this->email,
            'phone' => $this->phone,
            'notes' => $this->when(Route::is('customers.show'), $this->notes),
            'associated_workings' => $this->whenLoaded('associated_workings'),
            'workings' => $this->whenLoaded('workings'),
            'orders' => $this->whenLoaded('orders'),
        ];
    }
}
