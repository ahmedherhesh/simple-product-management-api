<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

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

    public function getProduct(Product $product): Product
    {
        return $product;
    }

    public function createProduct($data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function updateProductStatus(Product $product, string $status): Product
    {
        $product->update(['status' => $status]);
        return $product;
    }

    public function deleteProduct(Product $product): Product
    {
        $product->delete();
        return $product;
    }
}
