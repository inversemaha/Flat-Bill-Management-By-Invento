<?php

namespace App\Services;

use App\Contracts\FlatRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FlatService extends BaseService
{
    public function __construct(FlatRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create flat with validation
     */
    public function createFlat(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->repository->create($data);
        });
    }

    /**
     * Get flats with building information
     */
    public function getFlatsWithBuilding()
    {
        return $this->repository->with(['building', 'tenants'])->all();
    }

    /**
     * Find flat by ID with all details
     */
    public function findByIdWithDetails($id)
    {
        return $this->repository->with(['building', 'tenants'])->find($id);
    }

    /**
     * Check if flat number exists in building
     */
    public function flatNumberExists($buildingId, $flatNumber)
    {
        return $this->repository->flatNumberExistsInBuilding($buildingId, $flatNumber);
    }

    /**
     * Check if flat number exists excluding current flat
     */
    public function flatNumberExistsExcept($buildingId, $flatNumber, $excludeId)
    {
        return $this->repository->flatNumberExistsInBuilding($buildingId, $flatNumber, $excludeId);
    }

    /**
     * Get available flats (not occupied)
     */
    public function getAvailableFlats()
    {
        return $this->repository->with(['building'])->getAvailable()->all();
    }

    /**
     * Get occupied flats (with tenants)
     */
    public function getOccupiedFlats()
    {
        return $this->repository->with(['building', 'tenants'])->getOccupied()->all();
    }

    /**
     * Get available flats including a specific flat
     */
    public function getAvailableFlatsIncluding($flatId)
    {
        return $this->repository->with(['building'])
                                ->where(function($query) use ($flatId) {
                                    $query->where('is_occupied', false)
                                          ->orWhere('id', $flatId);
                                })
                                ->all();
    }

    /**
     * Check if flat is available
     */
    public function isFlatAvailable($flatId)
    {
        $flat = $this->repository->find($flatId);
        return $flat && !$flat->is_occupied;
    }
}
