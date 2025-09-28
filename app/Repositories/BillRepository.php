<?php

namespace App\Repositories;

use App\Contracts\BillRepositoryInterface;
use App\Models\Bill;
use Carbon\Carbon;

class BillRepository extends BaseRepository implements BillRepositoryInterface
{
    public function __construct(Bill $model)
    {
        parent::__construct($model);
    }

    /**
     * Get bills for a specific flat
     */
    public function getByFlat($flatId)
    {
        $this->query = $this->query->where('flat_id', $flatId);
        return $this;
    }

    /**
     * Get unpaid bills
     */
    public function getUnpaid()
    {
        $this->query = $this->query->unpaid();
        return $this;
    }

    /**
     * Get bills by status
     */
    public function getByStatus($status)
    {
        $this->query = $this->query->where('status', $status);
        return $this;
    }

    /**
     * Get bills by month and year
     */
    public function getByMonthYear($month, $year)
    {
        $this->query = $this->query->where('month', $month)->where('year', $year);
        return $this;
    }

    /**
     * Get overdue bills
     */
    public function getOverdue()
    {
        $this->query = $this->query->overdue();
        return $this;
    }
}
