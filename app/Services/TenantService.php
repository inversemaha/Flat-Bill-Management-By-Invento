<?php

namespace App\Services;

use App\Contracts\TenantRepositoryInterface;
use App\Contracts\FlatRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TenantService extends BaseService
{
    private $flatRepository;

    public function __construct(TenantRepositoryInterface $repository, FlatRepositoryInterface $flatRepository)
    {
        parent::__construct($repository);
        $this->flatRepository = $flatRepository;
    }

    /**
     * Create tenant with flat assignment
     */
    public function createTenant(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create tenant
            $tenant = $this->repository->create($data);

            // Mark flat as occupied
            if (isset($data['flat_id'])) {
                $this->updateFlatOccupancy($data['flat_id'], true);
            }

            return $tenant;
        });
    }

    /**
     * Update tenant
     */
    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tenant = $this->repository->find($id);
            if (!$tenant) {
                return false;
            }

            $oldFlatId = $tenant->flat_id;
            $newFlatId = $data['flat_id'] ?? null;

            // Update tenant
            $updated = $this->repository->update($id, $data);

            // Handle flat occupancy changes
            if ($oldFlatId !== $newFlatId) {
                if ($oldFlatId) {
                    $this->updateFlatOccupancy($oldFlatId, false);
                }
                if ($newFlatId) {
                    $this->updateFlatOccupancy($newFlatId, true);
                }
            }

            return $updated;
        });
    }

    /**
     * Delete tenant
     */
    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $tenant = $this->repository->find($id);
            if (!$tenant) {
                return false;
            }

            // Free up the flat
            if ($tenant->flat_id) {
                $this->updateFlatOccupancy($tenant->flat_id, false);
            }

            return $this->repository->delete($id);
        });
    }

    /**
     * Get tenants with flat information
     */
    public function getTenantsWithFlat()
    {
        return $this->repository->getTenantsWithFlat()->all();
    }

    /**
     * Find tenant by ID with all details
     */
    public function findByIdWithDetails($id)
    {
        return $this->repository->with(['flat.building'])->find($id);
    }

    /**
     * Get all active tenants
     */
    public function getAllActiveTenants()
    {
        return $this->repository->getActiveTenants()->all();
    }

    /**
     * Update flat occupancy status
     */
    private function updateFlatOccupancy($flatId, $isOccupied)
    {
        $flat = $this->flatRepository->find($flatId);
        if ($flat) {
            $this->flatRepository->update($flatId, ['is_occupied' => $isOccupied]);
        }
    }
}
