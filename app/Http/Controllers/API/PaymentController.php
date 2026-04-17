<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $service;

    public function __construct(PaymentService $service)
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
            'lease_id' => 'required|exists:leases,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'month' => 'required|string',
            'status' => 'in:paid,due,partial,unpaid',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        return response()->json($this->service->store($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'lease_id' => 'sometimes|exists:leases,id',
            'amount' => 'sometimes|numeric',
            'payment_date' => 'sometimes|date',
            'month' => 'sometimes|string',
            'status' => 'in:paid,due,partial,unpaid',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
