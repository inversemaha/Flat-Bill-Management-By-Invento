<?php

namespace App\Contracts;

interface FlatRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get flats for a specific building
     */
    public function getByBuilding($buildingId);

    /**
     * Get available flats (not occupied)
     */
    public function getAvailable();

    /**
     * Get occupied flats
     */
    public function getOccupied();

    /**
     * Get flats with tenants
     */
    public function withTenants();

    /**
     * Check if flat number exists in building
     */
    public function flatNumberExistsInBuilding($buildingId, $flatNumber, $excludeId = null);
}
