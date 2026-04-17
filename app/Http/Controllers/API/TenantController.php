<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function index()
    {
        return response()->json(
            $this->tenantService->listTenants(auth()->id())
        );
    }

    public function show($id)
    {
        return response()->json(
            $this->tenantService->getTenant($id, auth()->id())
        );
    }

    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20|unique:tenants,phone',
                'email' => 'required|email|max:255|unique:tenants,email',
                'nid_number' => 'nullable|string|max:50|unique:tenants,email',
                'address' => 'nullable|string',
            ]);

            return response()->json(
                $this->tenantService->createTenant($data, auth()->id()),
                201
            );

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Already exists or You need to must fill all required fields and unique fields',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20|unique:tenants,phone,' . $id,
                'email' => 'required|email|max:255|unique:tenants,email,' . $id,
                'nid_number' => 'nullable|string|max:50|unique:tenants,nid_number,' . $id,
                'address' => 'nullable|string',
            ]);

            return response()->json(
                $this->tenantService->updateTenant($id, auth()->id(), $data)
            );

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $this->tenantService->deleteTenant($id, auth()->id());

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
