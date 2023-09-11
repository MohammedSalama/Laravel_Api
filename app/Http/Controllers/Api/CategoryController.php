<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = auth()->user()->categories()->create($request->validated());
//         $category = Category::create($request->validated() + ['user_id' => auth()->id()]);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (! $category)
            abort('404','Category Not Found');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update(['name' => $request->name]);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
