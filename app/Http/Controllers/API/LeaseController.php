<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\LeaseService;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    protected $service;

    public function __construct(LeaseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function show($id)
    {
        return response()->json($this->service->show($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required',
            'tenant_id' => 'required',
            'unit_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'required|numeric',
            'deposit_amount' => 'nullable|numeric',
            'status' => 'in:active,ended',
        ]);

        return response()->json($this->service->store($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'property_id' => 'sometimes',
            'tenant_id' => 'sometimes',
            'unit_id' => 'sometimes',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date',
            'rent_amount' => 'sometimes|numeric',
            'deposit_amount' => 'nullable|numeric',
            'status' => 'in:active,ended',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
