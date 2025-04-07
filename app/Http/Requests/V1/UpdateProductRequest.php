<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
                'categoryId' => ['required','integer'],
                'name' => ['required'],
                'amount' => ['required', 'numeric'],
                'price' => ['required', 'numeric'],
                'status' => ['required', Rule::in(['A','N','a','n'])], //aktif, nonaktif
            ];
        } else {
            return [
                'categoryId' => ['sometimes','required','integer'],
                'name' => ['sometimes','required'],
                'amount' => ['sometimes','required', 'numeric'],
                'price' => ['sometimes','required', 'numeric'],
                'status' => ['sometimes','required', Rule::in(['A','N','a','n'])],
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->customer_id or $this->billedDate or $this->paidDate) {
            $this->merge([
                'category_id' => $this->categoryId,
            ]);
        }
    }
}
