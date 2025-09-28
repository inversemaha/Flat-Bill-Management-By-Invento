<?php

namespace App\Repositories;

use App\Contracts\BuildingRepositoryInterface;
use App\Models\Building;

class BuildingRepository extends BaseRepository implements BuildingRepositoryInterface
{
    public function __construct(Building $model)
    {
        parent::__construct($model);
    }

    /**
     * Get buildings for a specific house owner
     */
    public function getByHouseOwner($houseOwnerId)
    {
        $this->query = $this->query->where('house_owner_id', $houseOwnerId);
        return $this;
    }

    /**
     * Get buildings with flats count
     */
    public function withFlatsCount()
    {
        $this->query = $this->query->withCount('flats');
        return $this;
    }

    /**
     * Search buildings by name or address
     */
    public function search($searchQuery)
    {
        $this->query = $this->query->where(function ($q) use ($searchQuery) {
            $q->where('name', 'LIKE', "%{$searchQuery}%")
              ->orWhere('address', 'LIKE', "%{$searchQuery}%")
              ->orWhere('city', 'LIKE', "%{$searchQuery}%");
        });
        return $this;
    }
}
