<?php

namespace App\Repositories;

use App\Models\BillCategory;
use App\Contracts\BillCategoryRepositoryInterface;

class BillCategoryRepository extends BaseRepository implements BillCategoryRepositoryInterface
{
    /**
     * Create a new repository instance.
     */
    public function __construct(BillCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active bill categories
     */
    public function getActiveBillCategories()
    {
        $this->query = $this->query->where('is_active', true);
        return $this;
    }

    /**
     * Get bill categories by house owner
     */
    public function getByHouseOwner($houseOwnerId)
    {
        $this->query = $this->query->where('house_owner_id', $houseOwnerId);
        return $this;
    }
}
