<?php

namespace App\Repositories\Contracts;

interface PaymentRepositoryInterface
{
    public function getAllByUser($userId);
    public function findById($id, $userId);
    public function create(array $data);
    public function update($id, $userId, array $data);
    public function delete($id, $userId);
}