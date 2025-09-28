<?php

namespace App\Repositories;

use App\Models\Tenant;
use App\Contracts\TenantRepositoryInterface;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    /**
     * Create a new repository instance.
     */
    public function __construct(Tenant $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active tenants
     */
    public function getActiveTenants()
    {
        $this->query = $this->query->where('is_active', true);
        return $this;
    }

    /**
     * Find tenant by flat ID
     */
    public function findByFlatId($flatId)
    {
        $result = $this->query->where('flat_id', $flatId)->first();
        $this->resetQuery();
        return $result;
    }

    /**
     * Get tenants with their flats and buildings
     */
    public function getTenantsWithFlat()
    {
        $this->query = $this->query->with(['flat.building']);
        return $this;
    }

    /**
     * Get all tenants (active and inactive)
     */
    public function getAllTenants()
    {
        $this->query = $this->query->with(['flat.building']);
        return $this;
    }
}
