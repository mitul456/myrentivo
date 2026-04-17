<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function index(Request $request)
    {
        $properties = $this->propertyService->list($request->user()->id);
        return response()->json($properties);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'total_units' => 'required|integer',
        ]);

        $property = $this->propertyService->store($data, $request->user()->id);

        return response()->json($property, 201);
    }

    public function show($id, Request $request)
    {
        $property = $this->propertyService->show($id);

        if ($property->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json($property);
    }

    public function update(Request $request, Property $property)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'total_units' => 'required|integer',
        ]);

        // ownership check
        if ($property->user_id !== auth()->id()) {
            abort(403);
        }

        $property = $this->propertyService->update($property, $data);

        return response()->json($property);
    }

    public function destroy($id)
    {
        $this->propertyService->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
