<?php

namespace App\Repositories;

use App\Contracts\FlatRepositoryInterface;
use App\Models\Flat;

class FlatRepository extends BaseRepository implements FlatRepositoryInterface
{
    public function __construct(Flat $model)
    {
        parent::__construct($model);
    }

    /**
     * Get flats for a specific building
     */
    public function getByBuilding($buildingId)
    {
        $this->query = $this->query->where('building_id', $buildingId);
        return $this;
    }

    /**
     * Get available flats (not occupied)
     */
    public function getAvailable()
    {
        $this->query = $this->query->where('is_occupied', false);
        return $this;
    }

    /**
     * Get occupied flats
     */
    public function getOccupied()
    {
        $this->query = $this->query->where('is_occupied', true);
        return $this;
    }

    /**
     * Get flats with tenants relationship
     */
    public function withTenants()
    {
        $this->query = $this->query->with('tenants');
        return $this;
    }

    /**
     * Check if flat number exists in building
     */
    public function flatNumberExistsInBuilding($buildingId, $flatNumber, $excludeId = null)
    {
        $query = $this->query->where('building_id', $buildingId)->where('flat_number', $flatNumber);

        if ($excludeId) {
            $query = $query->where('id', '!=', $excludeId);
        }

        $result = $query->exists();
        $this->resetQuery();
        return $result;
    }
}
