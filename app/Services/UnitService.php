<?php

namespace App\Services;

use App\Models\Property;
use App\Repositories\Contracts\UnitRepositoryInterface;

class UnitService
{
    protected $unitRepository;

    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function listUnits($userId)
    {
        return $this->unitRepository->getAllByUser($userId);
    }

    public function getUnit($id, $userId)
    {
        return $this->unitRepository->findById($id, $userId);
    }

    public function createUnit($data, $userId)
    {
        $data['user_id'] = $userId;
        return $this->unitRepository->create($data);
    }

    public function updateUnit($id, $userId, $data)
    {
        return $this->unitRepository->update($id, $userId, $data);
    }

    public function deleteUnit($id, $userId)
    {
        return $this->unitRepository->delete($id, $userId);
    }
}
