<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
public function getAllByUser($userId)
    {
        return Notification::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function findById($id, $userId)
    {
        return Notification::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $notification = $this->findById($id, $userId);
        $notification->update($data);
        return $notification;
    }

    public function delete($id, $userId)
    {
        $notification = $this->findById($id, $userId);
        return $notification->delete();
    }

    public function markAsRead($id, $userId)
    {
        $notification = $this->findById($id, $userId);
        $notification->update(['is_read' => true]);
        return $notification;
    }
}