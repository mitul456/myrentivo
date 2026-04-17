<?php

namespace App\Repositories\Contracts;

interface PropertyRepositoryInterface
{
    public function getAll($userId);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}