<?php

namespace App\Services;

use App\Models\Property;
use App\Repositories\Contracts\UnitRepositoryInterface;

class UnitService
{
    public function __construct(
        protected UnitRepositoryInterface $repository
    ) {}

    public function getAll($userId)
    {
        return $this->repository->all($userId);
    }

    public function find($id, $userId)
    {
        return $this->repository->find($id, $userId);
    }

    public function store(array $data, $userId)
    {
        // 🔒 ownership check
        $property = Property::where('id', $data['property_id'])
            ->where('user_id', $userId)
            ->firstOrFail();

        return $property->units()->create($data);
    }

    public function update($id, array $data, $userId)
    {
        return $this->repository->update($id, $data, $userId);
    }

    public function delete($id, $userId)
    {
        return $this->repository->delete($id, $userId);
    }
}
