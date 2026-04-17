<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\Contracts\UnitRepositoryInterface;

class UnitRepository implements UnitRepositoryInterface
{
    public function getAllByUser($userId)
    {
        return Unit::where('user_id', $userId)->get();
    }

    public function findById($id, $userId)
    {
        return Unit::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Unit::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $unit = $this->findById($id, $userId);
        $unit->update($data);
        return $unit;
    }

    public function delete($id, $userId)
    {
        $unit = $this->findById($id, $userId);
        return $unit->delete();
    }
}