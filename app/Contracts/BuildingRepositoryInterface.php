<?php

namespace App\Contracts;

interface BuildingRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get buildings for a specific house owner
     */
    public function getByHouseOwner($houseOwnerId);

    /**
     * Get buildings with flats count
     */
    public function withFlatsCount();

    /**
     * Search buildings by name or address
     */
    public function search($query);
}
