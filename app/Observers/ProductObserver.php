<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ProductService;

class ProductObserver
{
    public function created(Product $product)
    {
        (new ProductService)->appendProductImages($product, request()->file('images'));
    }
}
