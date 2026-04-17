<?php

namespace App\Services;

use App\Models\Property;
use App\Repositories\Contracts\ExpenseRepositoryInterface;

class ExpenseService
{
protected $repo;

    public function __construct(ExpenseRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->getAllByUser(auth()->id());
    }

    public function show($id)
    {
        return $this->repo->findById($id, auth()->id());
    }

    public function store($data)
    {
        $userId = auth()->id();

        // 🔐 Ensure property belongs to this user
        Property::where('id', $data['property_id'])
            ->where('user_id', $userId)
            ->firstOrFail();

        $data['user_id'] = $userId;

        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        $userId = auth()->id();

        // 🔐 Prevent switching to чужা property
        if (isset($data['property_id'])) {
            Property::where('id', $data['property_id'])
                ->where('user_id', $userId)
                ->firstOrFail();
        }

        return $this->repo->update($id, $userId, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id, auth()->id());
    }
}