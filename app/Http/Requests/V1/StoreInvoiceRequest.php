<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerId'  => 'required|integer',
            'amount' => 'required|decimal:2',
            'status' => ['required', Rule::in(['V', 'B', 'P', 'v', 'b', 'p'])],
            'billedDate' => 'required|date_equals:date',
            'paidDate' => 'date_equals:date',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->customerId,
            'billed_date' => $this->billedDate,
            'paid_date' => $this->paidDate,
        ]);
    }
}
