<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customerId' => 'integer',
            'amount' => 'decimal:2',
            'status' => [Rule::in(['V', 'B', 'P', 'v', 'b', 'p'])],
            'billedDate' => 'date_equals:date',
            'paidDate' => 'date_equals:date',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->customerId) {
            $this->merge([
                'customer_id' => $this->customerId,
            ]);
        }
        if ($this->billedDate) {
            $this->merge([
                'billed_date' => $this->billedDate,
            ]);
        }
        if ($this->paidDate) {
            $this->merge([
                'paid_date' => $this->paidDate,
            ]);
        }
    }
}
