<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductFilterRequest $request, ProductService $productService)
    {
        return $productService->getProducts()->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request, ProductService $productService)
    {
        return $productService->createProduct($request->validated())->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, ProductService $productService)
    {
        return $productService->getProduct($product)->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product, ProductService $productService)
    {
        return $productService->updateProduct($product, $request->validated())->toResource();
    }

    public function updateStatus(UpdateStatusRequest $request, Product $product, ProductService $productService)
    {
        return $productService->updateProductStatus($product, $request->status)->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductService $productService)
    {
        return $productService->deleteProduct($product)->toResource();
    }
}
