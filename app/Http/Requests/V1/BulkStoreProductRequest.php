<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.categoryId' => ['required','integer'],
            '*.name' => ['required'],
            '*.amount' => ['required', 'numeric'],
            '*.price' => ['required','numeric'],
            '*.status' => ['required', Rule::in(['A','N','a','n'])],
        ];
    }

    protected function prepareForValidation()
    {
       $data = [];

       foreach($this->toArray() as $obj){
        $obj['category_id'] = $obj['categoryId'] ?? null;

        $data[] = $obj;
       }

       $this->merge($data);
    }
}
