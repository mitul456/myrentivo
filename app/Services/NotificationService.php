<?php

namespace App\Services;

use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationService
{
    protected $repo;

    public function __construct(NotificationRepositoryInterface $repo)
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
        $data['user_id'] = auth()->id();
        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, auth()->id(), $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id, auth()->id());
    }

    public function markAsRead($id)
    {
        return $this->repo->markAsRead($id, auth()->id());
    }
}