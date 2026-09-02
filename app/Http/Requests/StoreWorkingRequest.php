<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkingRequest extends FormRequest
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
            'customer_id' => 'nullable|exists:customers,id',
            'customer.name' => 'nullable|string',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string',
            'customer.is_company' => 'nullable|boolean',
            'customer.company_name' => 'nullable|string',
            'workings.*.company_id' => 'nullable|exists:customers,id',
            'workings.*.working_id' => 'nullable',
            'workings.*.working_status_id' => 'required|exists:working_statuses,id',
            'workings.*.brand_id' => 'required|exists:brands,id',
            'workings.*.reference' => 'required',
            'workings.*.acceptance_date' => 'nullable|date',
            'workings.*.delivery_date' => 'nullable|date',
            'workings.*.working_description' => 'nullable|string',
            'workings.*.payment_method_id' => 'nullable|exists:payment_methods,id',
            'workings.*.total_cost' => 'min:0',
            'workings.*.extra_notes' => 'nullable|string'
        ];
    }

    public function message() : array {
        return [
            'customer_id.exists' => 'Il cliente selezionato non esiste.',
            'customer.name.string' => 'Il nome del cliente deve essere una stringa.',
            'customer.email.email' => 'L\'indirizzo email deve essere valido.',
            'customer.phone.string' => 'Il telefono deve essere una stringa.',
            'customer.is_company.boolean' => 'Il campo è azienda deve essere un valore booleano.',
            'customer.company_name.string' => 'Il nome dell\'azienda deve essere una stringa.',
            'workings.*.company_id.exists' => 'L\'azienda selezionata non esiste.',
            'workings.*.working_status_id.required' => 'Lo stato del lavoro è obbligatorio.',
            'workings.*.working_status_id.exists' => 'Lo stato del lavoro selezionato non esiste.',
            'workings.*.brand_id.required' => 'Il marchio è obbligatorio.',
            'workings.*.brand_id.exists' => 'Il marchio selezionato non esiste.',
            'workings.*.reference.required' => 'Il riferimento è obbligatorio.',
            'workings.*.acceptance_date.date' => 'La data di accettazione deve essere una data valida.',
            'workings.*.delivery_date.date' => 'La data di consegna deve essere una data valida.',
            'workings.*.working_description.string' => 'La descrizione del lavoro deve essere una stringa.',
            'workings.*.payment_method_id.exists' => 'Il metodo di pagamento selezionato non esiste.',
            'workings.*.total_cost.min' => 'Il costo totale deve essere almeno 0.',
            'workings.*.extra_notes.string' => 'Le note aggiuntive devono essere una stringa.',
        ];
    }
}
