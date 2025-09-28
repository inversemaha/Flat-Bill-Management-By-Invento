<?php

namespace App\Contracts;

interface TenantRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active tenants
     */
    public function getActiveTenants();

    /**
     * Find tenant by flat ID
     */
    public function findByFlatId($flatId);

    /**
     * Get tenants with their flats and buildings
     */
    public function getTenantsWithFlat();
}
