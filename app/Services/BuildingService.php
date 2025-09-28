<?php

namespace App\Services;

use App\Contracts\BuildingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BuildingService extends BaseService
{
    public function __construct(BuildingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create building with house owner validation
     */
    public function createBuilding(array $data)
    {
        // Ensure the current user is set as house owner
        if (auth()->check() && auth()->user()->role === 'house_owner') {
            $data['house_owner_id'] = auth()->id();
        }

        return DB::transaction(function () use ($data) {
            return $this->repository->create($data);
        });
    }

    /**
     * Get buildings with additional statistics
     */
    public function getBuildingsWithStats()
    {
        return $this->repository->with(['flats', 'tenants'])
                               ->withFlatsCount()
                               ->all();
    }

    /**
     * Get all buildings for dropdowns
     */
    public function getAllBuildings()
    {
        return $this->repository->all();
    }

    /**
     * Search buildings
     */
    public function searchBuildings($query)
    {
        return $this->repository->search($query)->all();
    }

    /**
     * Get buildings for current house owner
     */
    public function getMyBuildings()
    {
        if (auth()->check() && auth()->user()->role === 'house_owner') {
            return $this->repository->getByHouseOwner(auth()->id())->all();
        }
        return collect();
    }
}
