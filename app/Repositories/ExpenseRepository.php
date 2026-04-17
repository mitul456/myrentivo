<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{
public function getAllByUser($userId)
    {
        return Expense::where('user_id', $userId)->latest()->get();
    }

    public function findById($id, $userId)
    {
        return Expense::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return Expense::create($data);
    }

    public function update($id, $userId, array $data)
    {
        $expense = $this->findById($id, $userId);
        $expense->update($data);
        return $expense;
    }

    public function delete($id, $userId)
    {
        $expense = $this->findById($id, $userId);
        return $expense->delete();
    }
}