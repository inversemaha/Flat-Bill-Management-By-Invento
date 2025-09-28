<?php

namespace App\Services;

use App\Contracts\BillRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BillService extends BaseService
{
    public function __construct(BillRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create bill with notification
     */
    public function createBill(array $data)
    {
        $data['status'] = $data['status'] ?? 'pending';
        return $this->repository->create($data);
    }

    /**
     * Get bills with filters
     */
    public function getBillsWithFilters(array $filters = [])
    {
        $query = $this->repository->with(['tenant.flat.building', 'billCategory']);

        // Apply filters if provided
        if (!empty($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }

        if (!empty($filters['tenant_id'])) {
            $query = $query->where('tenant_id', $filters['tenant_id']);
        }

        if (!empty($filters['category_id'])) {
            $query = $query->where('bill_category_id', $filters['category_id']);
        }

        return $query->all();
    }

    /**
     * Find bill by ID with all details
     */
    public function findByIdWithDetails($id)
    {
        return $this->repository->with(['tenant.flat.building', 'billCategory'])->find($id);
    }

    /**
     * Mark bill as paid
     */
    public function markAsPaid($id)
    {
        return $this->repository->update($id, [
            'status' => 'paid',
            'paid_date' => now()
        ]);
    }

    /**
     * Generate monthly bills for all active tenants
     */
    public function generateMonthlyBills($month, $year, $categoryId)
    {
        // This would need TenantService injection to get active tenants
        // For now, return 0 as placeholder
        return 0;
    }

    /**
     * Send bill created notification
     */
    public function sendBillCreatedNotification($bill)
    {
        // Placeholder for email notification
        // Would implement actual notification logic here
        return true;
    }

    /**
     * Send bill paid notification
     */
    public function sendBillPaidNotification($bill)
    {
        // Placeholder for email notification
        // Would implement actual notification logic here
        return true;
    }
}
