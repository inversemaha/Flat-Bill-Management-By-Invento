<?php

namespace App\Services;

use App\Contracts\BillCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BillCategoryService extends BaseService
{
    public function __construct(BillCategoryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create bill category
     */
    public function createBillCategory(array $data)
    {
        $data['is_active'] = $data['is_active'] ?? true;
        return $this->repository->create($data);
    }

    /**
     * Get all bill categories
     */
    public function getAllBillCategories()
    {
        return $this->repository->all();
    }

    /**
     * Get all active bill categories
     */
    public function getAllActiveBillCategories()
    {
        return $this->repository->getActiveBillCategories()->all();
    }

    /**
     * Find category by ID with bills
     */
    public function findByIdWithBills($id)
    {
        return $this->repository->with(['bills'])->find($id);
    }

    /**
     * Check if category name exists
     */
    public function categoryNameExists($name)
    {
        return $this->repository->where('name', $name)->exists();
    }

    /**
     * Check if category name exists excluding current category
     */
    public function categoryNameExistsExcept($name, $excludeId)
    {
        return $this->repository->where('name', $name)
                                ->where('id', '!=', $excludeId)
                                ->exists();
    }
}
