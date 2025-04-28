<?php

namespace App\Services;

use App\Exceptions\ProductException;
use App\Models\Product;
use Exception;

class ProductService
{
    public function getProducts($paginate = 10)
    {
        $request = request();

        $query = Product::latest();

        $filters = [
            'name'      => fn($q, $value) => $q->where('name', 'LIKE', "%{$value}%"),
            'status'    => fn($q, $value) => $q->whereStatus($value),
            'min_price' => fn($q, $value) => $q->where('price', '>=', $value),
            'max_price' => fn($q, $value) => $q->where('price', '<=', $value),
        ];

        foreach ($filters as $key => $filter) :
            $query = $query->when($request->{$key}, $filter);
        endforeach;

        return $query->paginate($paginate);
    }

    public function getProduct($id): Product | Exception
    {
        $product = Product::find($id);

        if (!$product)
            throw new ProductException('Product was not found', 404);

        return $product;
    }

    public function createProduct($data): Product | Exception
    {
        $product = Product::create($data);

        if (!$product)
            throw new ProductException('Product was not created', 500);

        return $product;
    }

    public function updateProduct($id, $data): Product | Exception
    {
        $product = Product::find($id);
        if (!$product)
            throw new ProductException('Product was not found', 404);

        $updateProduct = $product->update($data);
        if (!$updateProduct)
            throw new ProductException('Product was not updated', 500);

        return $product;
    }

    public function updateProductStatus($id, string $status): Product | Exception
    {
        $product = Product::find($id);
        if (!$product)
            throw new ProductException('Product was not found', 404);

        $statusUpdated = $product->update(['status' => $status]);
        if (!$statusUpdated)
            throw new ProductException('Product status was not updated', 500);

        return $product;
    }

    public function appendProductImages(Product $product, array $requestImages): Product | Exception
    {
        $appendedImages = [];
        if ($requestImages && count($requestImages) > 0) {
            foreach ($requestImages as $image) {
                $image_name =  rand(1000, 9999) . time() . '.' . $image->extension();
                $image->move(public_path("uploads/product-images"), $image_name);
                $product->addMedia(public_path("uploads/product-images/$image_name"))->toMediaCollection('product-images');
                $appendedImages[] = $image_name;
            }
        }
        if (!$appendedImages)
            throw new ProductException('The product image does not saved', 500);
        return $product;
    }

    public function deleteProduct($id): Product | Exception
    {
        $product = Product::find($id);
        if (!$product)
            throw new ProductException('Product was not found', 404);

        $productDeleted = $product->delete();
        if (!$productDeleted)
            throw new ProductException('Product was not deleted', 500);

        return $product;
    }
}
