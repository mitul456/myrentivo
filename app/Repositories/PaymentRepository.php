<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
public function getAllByUser($userId)
    {
        return Payment::where('user_id', $userId)->latest()->get();
    }

    public function findById($id, $userId)
    {
        return Payment::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $payment = $this->findById($id, $userId);
        $payment->update($data);
        return $payment;
    }

    public function delete($id, $userId)
    {
        $payment = $this->findById($id, $userId);
        return $payment->delete();
    }
}