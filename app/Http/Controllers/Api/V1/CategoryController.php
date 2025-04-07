<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CategoriesFilter;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use App\Http\Requests\V1\StoreCategoryRequest;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateCategoryRequest;
use App\Http\Resources\V1\ProductResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CategoriesFilter();
        $filterItems = $filter->transform($request); //[['column','operator','value']]

        $includeProducts = $request->query('includeProducts');

        $categories = Category::where($filterItems);
        
        if($includeProducts){
            $categories=$categories->with('products');
        }

        return new CategoryCollection($categories->paginate()->appends($request->query()));

        
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Category::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $includeProducts = request()->query('includeProducts');

        if($includeProducts){
            return new ProductResource($category->loadMissing('products'));
        }

        return new ProductResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
       
        $category = Category::find($id);
 
        //cek kalau  tidak ditemukan
        if(!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'],404);
        }

        //hapus dari tabel 
        $category->delete();
    }
}
