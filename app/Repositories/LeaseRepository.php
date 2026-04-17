<?php

namespace App\Repositories;

use App\Models\Lease;
use App\Repositories\Contracts\LeaseRepositoryInterface;

class LeaseRepository implements LeaseRepositoryInterface
{
public function getAllByUser($userId)
    {
        return Lease::where('user_id', $userId)->get();
    }

    public function findById($id, $userId)
    {
        return Lease::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Lease::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $lease = $this->findById($id, $userId);
        $lease->update($data);
        return $lease;
    }

    public function delete($id, $userId)
    {
        $lease = $this->findById($id, $userId);
        return $lease->delete();
    }
}