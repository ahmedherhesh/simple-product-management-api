<?php

namespace App\Services;

use App\Exceptions\ProductException;
use App\Models\Product;

class ProductService
{
    public function getProducts($paginate = 10)
    {
        $request = request();

        $query = Product::query();

        $filters = [
            'name'      => fn($q, $value) => $q->whereLike('name', $value),
            'status'    => fn($q, $value) => $q->whereStatus($value),
            'min_price' => fn($q, $value) => $q->where('price', '>=', $value),
            'max_price' => fn($q, $value) => $q->where('price', '<=', $value),
        ];

        foreach ($filters as $key => $filter) :
            $query = $query->when($request->{$key}, $filter);
        endforeach;

        return $query->paginate($paginate);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product)
            throw new ProductException('Product not found', 404);

        return $product;
    }

    public function createProduct($data)
    {
        $product = Product::create($data);

        if (!$product)
            throw new ProductException('Product not created', 500);

        return $product;
    }

    public function updateProduct($id, $data)
    {
        $product = Product::find($id);
        if (!$product)
            throw new ProductException('Product not found', 404);

        $updateProduct = $product->update($data);
        if (!$updateProduct)
            throw new ProductException('Product not updated', 500);

        return $product;
    }

    public function updateProductStatus($id, string $status)
    {
        $product = Product::find($id);
        if (!$product)
            throw new ProductException('Product not found', 404);

        $statusUpdated = $product->update(['status' => $status]);
        if (!$statusUpdated)
            throw new ProductException('Product not updated', 500);

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product)
            throw new ProductException('Product not found', 404);

        $productDeleted = $product->delete();
        if (!$productDeleted)
            throw new ProductException('Product not deleted', 500);

        return $product;
    }
}
