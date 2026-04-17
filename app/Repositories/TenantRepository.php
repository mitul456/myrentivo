<?php

namespace App\Repositories;

use App\Models\Tenant;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantRepository implements TenantRepositoryInterface
{
    public function getAllByUser($userId)
    {
        return Tenant::where('user_id', $userId)->get();
    }

    public function findById($id, $userId)
    {
        return Tenant::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Tenant::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $tenant = $this->findById($id, $userId);
        $tenant->update($data);
        return $tenant;
    }

    public function delete($id, $userId)
    {
        $tenant = $this->findById($id, $userId);
        return $tenant->delete();
    }
}