<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductImagesRequest;
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
    public function show($id, ProductService $productService)
    {
        return $productService->getProduct($id)->toResource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id, ProductService $productService)
    {
        return $productService->updateProduct($id, $request->validated())->toResource();
    }

    public function updateStatus(UpdateStatusRequest $request, $id, ProductService $productService)
    {
        return $productService->updateProductStatus($id, $request->status)->toResource();
    }

    public function updateImages(UpdateProductImagesRequest $request, $id, ProductService $productService)
    {
        $product = $productService->getProduct($id);
        return $productService->appendProductImages($product, $request->images)->toResource();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, ProductService $productService)
    {
        return $productService->deleteProduct($id)->toResource();
    }
}
