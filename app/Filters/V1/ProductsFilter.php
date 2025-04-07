<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class ProductsFilter extends ApiFilter {

    protected $fillable = [
        'kategori_id',
        'name',
        'amount',
        'price',
        'status',
    ];
    protected $safeParms = [
        'categoryId' => ['eq'],
        'name' => ['eq'],
        'amount' => ['eq','gt','lt','lte','gte'],
        'price' => ['eq','gt','lt','lte','gte'],
        'status' => ['eq','ne'],
    ];

    protected $columnMap = [
        'categoryId' => 'category_id',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '≤',
        'gt' => '>',
        'gte' => '≥',
        'ne' => '!=',
    ];

}