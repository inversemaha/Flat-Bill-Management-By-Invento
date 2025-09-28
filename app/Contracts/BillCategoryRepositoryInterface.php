<?php

namespace App\Contracts;

interface BillCategoryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active bill categories
     */
    public function getActiveBillCategories();

    /**
     * Get bill categories by house owner
     */
    public function getByHouseOwner($houseOwnerId);
}
