<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct(
        protected UnitService $service
    ) {}

    // 🔹 GET ALL
    public function index()
    {
        $userId = auth()->id();
        return response()->json(
            $this->service->getAll($userId)
        );
    }

    // 🔹 CREATE
    public function store(Request $request)
    {
        $userId = auth()->id();

        $data = $request->validate([
            'property_id' => 'required|integer',
            'unit_number' => 'required|string|unique:units,unit_number',
            'floor' => 'required|integer',
            'rent_amount' => 'required|numeric',
            'status' => 'required|string'
        ]);

        return response()->json(
            $this->service->store($data, $userId)
        );
    }

    // 🔹 SHOW
    public function show($id)
    {
        $userId = auth()->id();

        return response()->json(
            $this->service->find($id, $userId)
        );
    }

    // 🔹 UPDATE
    public function update(Request $request, $id)
    {
        $userId = auth()->id();

        $data = $request->validate([
            'property_id' => 'required|integer',
            'unit_number' => 'required|string|unique:units,unit_number,' . $id,
            'floor' => 'required|integer',
            'rent_amount' => 'required|numeric',
            'status' => 'required|string'
        ]);

        return response()->json(
            $this->service->update($id, $data, $userId)
        );
    }

    // 🔹 DELETE
    public function destroy($id)
    {
        $userId = auth()->id();

        return response()->json([
            'deleted' => $this->service->delete($id, $userId)
        ]);
    }
}
