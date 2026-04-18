<?php

namespace App\Services;

use App\Repositories\Contracts\LeaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LeaseService
{
    protected $repo;

    public function __construct(LeaseRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->getAllByUser(auth()->id());
    }

    public function show($id)
    {
        return $this->repo->findById($id, auth()->id());
    }

    public function store($data)
    {
        $data['user_id'] = auth()->id();
        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, auth()->id(), $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id, auth()->id());
    }

    public function createLease(array $data)
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = auth()->id();
            $lease = $this->repo->create($data);

            // Update unit status
            if ($lease->unit) {
                $lease->unit->update([
                    'status' => 'occupied'
                ]);
            }

            DB::commit();

            return $lease;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function endLease($leaseId)
    {
        DB::beginTransaction();

        try {
            $lease = $this->repo->findById($leaseId, auth()->id());

            // 1. Lease end করো
            $lease->update([
                'status' => 'ended',
                'end_date' => now(),
            ]);

            // 2. Check if any active lease still exists for this unit
            $activeLease = $lease->unit->leases()
                ->where('status', 'active')
                ->exists();

            // 3. যদি আর active lease না থাকে → vacant
            if (!$activeLease) {
                $lease->unit->update([
                    'status' => 'vacant'
                ]);
            }

            DB::commit();

            return $lease;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}