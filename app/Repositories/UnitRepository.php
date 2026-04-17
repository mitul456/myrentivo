<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\Contracts\UnitRepositoryInterface;

class UnitRepository implements UnitRepositoryInterface
{
public function all($userId)
    {
        return Unit::whereHas('property', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();
    }

    public function find($id, $userId)
    {
        return Unit::where('id', $id)
            ->whereHas('property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Unit::create($data);
    }

    public function update($id, array $data, $userId)
    {
        $unit = Unit::where('id', $id)
            ->whereHas('property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        $unit->update($data);
        return $unit;
    }

    public function delete($id, $userId)
    {
        $unit = Unit::where('id', $id)
            ->whereHas('property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->firstOrFail();

        return $unit->delete();
    }
}