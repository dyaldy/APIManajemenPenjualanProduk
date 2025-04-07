<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {

            return [
                'customerId' => ['required','integer'],
                'amount' => ['required', 'numeric'],
                'status' => ['required', Rule::in(['B','P','V','b','p','v'])],
                'billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['nullable', 'date_format:Y-m-d H:i:s'],
            ];
        } else {
            return [
                'customerId' => ['sometimes', 'required','integer'],
                'amount' => ['sometimes','required', 'numeric'],
                'status' => ['sometimes','required', Rule::in(['B','P','V','b','p','v'])],
                'billedDate' => ['sometimes','required', 'date_format:Y-m-d H:i:s'],
                'paidDate' => ['sometimes','nullable', 'date_format:Y-m-d H:i:s'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->customer_id or $this->billedDate or $this->paidDate) {
            $this->merge([
                'customer_id' => $this->customerId,
                'billed_date' => $this->billedDate,
                'paid_date' => $this->paidDate
            ]);
        }
    }
}
