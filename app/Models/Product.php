<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'amount',
        'price',
        'status',
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }
}
