<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'working_id' => 'required',
            'working_status_id' => 'required|exists:working_statuses,id',
            'brand_id' => 'required|exists:brands,id',
            'reference' => 'required',
            'acceptance_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'working_description' => 'nullable|string',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'total_cost' => 'nullable|numeric',
            'extra_notes' => 'nullable|string'
        ];
    }

    public function messages() : array {
        return [
            'customer_id.required' => 'Il campo cliente è obbligatorio.',
            'customer_id.exists' => 'Il cliente selezionato non esiste.',
            'working_id.required' => 'Il campo ID lavorazione è obbligatorio.',
            'working_status_id.required' => 'Il campo stato lavorazione è obbligatorio.',
            'working_status_id.exists' => 'Lo stato lavorazione selezionato non esiste.',
            'brand_id.required' => 'Il campo marchio è obbligatorio.',
            'brand_id.exists' => 'Il marchio selezionato non esiste.',
            'reference.required' => 'Il campo riferimento è obbligatorio.',
            'acceptance_date.date' => 'La data di accettazione deve essere una data valida.',
            'delivery_date.date' => 'La data di consegna deve essere una data valida.',
            'working_description.string' => 'La descrizione della lavorazione deve essere una stringa.',
            'payment_method_id.exists' => 'Il metodo di pagamento selezionato non esiste.',
            'total_cost.numeric' => 'Il costo totale deve essere un numero.',
            'extra_notes.string' => 'Le note extra devono essere una stringa.',
        ];
    }
}
