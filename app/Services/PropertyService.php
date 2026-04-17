<?php

namespace App\Services;

use App\Repositories\Contracts\PropertyRepositoryInterface;

class PropertyService
{
    protected $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function list($userId)
    {
        return $this->propertyRepository->getAll($userId);
    }

    public function show($id)
    {
        return $this->propertyRepository->findById($id);
    }

    public function store($data, $userId)
    {
        $data['user_id'] = $userId;
        return $this->propertyRepository->create($data);
    }

    public function update($property, $data)
    {
        $property->update($data);
        return $property;
    }

    public function delete($id)
    {
        return $this->propertyRepository->delete($id);
    }
}
