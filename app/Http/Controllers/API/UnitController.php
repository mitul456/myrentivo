<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
   protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index()
    {
        return response()->json(
            $this->unitService->listUnits(auth()->id())
        );
    }

    public function show($id)
    {
        return response()->json(
            $this->unitService->getUnit($id, auth()->id())
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'unit_number' => 'required|unique:units',
            'floor' => 'required|integer',
            'rent_amount' => 'required|numeric',
            'status' => 'in:vacant,occupied'
        ]);

        return response()->json(
            $this->unitService->createUnit($data, auth()->id()),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'property_id' => 'sometimes|exists:properties,id',
            'unit_number' => "sometimes|unique:units,unit_number,$id",
            'floor' => 'sometimes|integer',
            'rent_amount' => 'sometimes|numeric',
            'status' => 'in:vacant,occupied'
        ]);

        return response()->json(
            $this->unitService->updateUnit($id, auth()->id(), $data)
        );
    }

    public function destroy($id)
    {
        $this->unitService->deleteUnit($id, auth()->id());

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
