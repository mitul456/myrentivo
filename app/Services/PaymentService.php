<?php

namespace App\Services;

use App\Models\Lease;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentService
{
    protected $repo;

    public function __construct(PaymentRepositoryInterface $repo)
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

        // 🔐 Ensure lease belongs to this user
        $lease = Lease::where('id', $data['lease_id'])
            ->where('user_id', $userId)
            ->firstOrFail();

        $data['user_id'] = $userId;

        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        $userId = auth()->id();

        // Optional: prevent changing lease_id to another user's lease
        if (isset($data['lease_id'])) {
            Lease::where('id', $data['lease_id'])
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