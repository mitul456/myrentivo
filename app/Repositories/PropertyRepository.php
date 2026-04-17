<?php

namespace App\Repositories;

use App\Models\Property;
use App\Repositories\Contracts\PropertyRepositoryInterface;

class PropertyRepository implements PropertyRepositoryInterface
{
    public function getAll($userId)
    {
        return Property::where('user_id', $userId)->get();
    }

    public function findById($id)
    {
        return Property::findOrFail($id);
    }

    public function create(array $data)
    {
        return Property::create($data);
    }

    public function update($property, array $data)
    {
        $property->update($data);
        return $property;
    }

    public function delete($id)
    {
        $property = Property::findOrFail($id);
        return $property->delete();
    }
}
