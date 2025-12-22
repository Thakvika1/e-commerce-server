<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CategoryRepository $repo
    ) {}

    public function paginate($perPage)
    {
        return $this->repo->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function find($id)
    {
        return $this->repo->findOrFail($id);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
