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

    public function paginate($perPage)
    {
        return Category::paginate($perPage);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function findOrFail($id)
    {
        return Category::findOrFail($id);
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
