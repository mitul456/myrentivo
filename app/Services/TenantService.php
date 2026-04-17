<?php

namespace App\Services;

use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantService
{
protected $tenantRepository;

    public function __construct(TenantRepositoryInterface $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    public function listTenants($userId)
    {
        return $this->tenantRepository->getAllByUser($userId);
    }

    public function getTenant($id, $userId)
    {
        return $this->tenantRepository->findById($id, $userId);
    }

    public function createTenant($data, $userId)
    {
        $data['user_id'] = $userId;
        return $this->tenantRepository->create($data);
    }

    public function updateTenant($id, $userId, $data)
    {
        return $this->tenantRepository->update($id, $userId, $data);
    }

    public function deleteTenant($id, $userId)
    {
        return $this->tenantRepository->delete($id, $userId);
    }
}