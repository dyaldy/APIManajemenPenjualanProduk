<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'categoryId' => $this->category_id,
            'name' =>$this->name,
            'amount' => $this->amount,
            'price' => $this->price,
            'status' => $this->status
        ];
    }
}
