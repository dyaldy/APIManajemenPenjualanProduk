<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ProductsFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Http\Requests\V1\BulkStoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductsFilter();
        $queryItems = $filter->transform($request); //[['column','operator','value']]

        if(count($queryItems) == 0){
            return new ProductCollection(Product::paginate());
        } else{
            $products = Product::where($queryItems)->paginate();
            return new ProductCollection($products->appends($request->query()));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        //
    }
    
    public function bulkStore (BulkStoreProductRequest $request){
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['categoryId']);
        });

        Product::insert($bulk->toArray());
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        //mencari kategori berdasarkan id
        $product =  Product::find($id);
 
        //cek kalau kategori tidak ditemukan
        if(!$product) {
            return response()->json(['message' => 'Product not found'],404);
        }

        //hapus dari tabel kategori
        $product->delete();
    }
}
