<?php

namespace App\Repositories\Contracts;

interface UnitRepositoryInterface
{
    public function all($userId);
    public function find($id, $userId);
    public function create(array $data);
    public function update($id, array $data, $userId);
    public function delete($id, $userId);
}