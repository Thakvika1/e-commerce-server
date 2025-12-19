<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function paginate($perPage)
    {
        return Product::with('category')->paginate($perPage);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function findOrFail($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        return Product::findOrFail($id)->delete();
    }
}
