<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function paginate()
    {
        return Category::with('products')->get();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function find($id)
    {
        $category = Category::with('products')->find($id);

        $category->products->transform(function ($product) {
            $product->image = asset('storage/' . $product->image);
            return $product;
        });

        return $category;
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        return Category::findOrFail($id)->delete();
    }
}
