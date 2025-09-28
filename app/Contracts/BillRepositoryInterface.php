<?php

namespace App\Contracts;

interface BillRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get bills for a specific flat
     */
    public function getByFlat($flatId);

    /**
     * Get unpaid bills
     */
    public function getUnpaid();

    /**
     * Get bills by status
     */
    public function getByStatus($status);

    /**
     * Get bills by month and year
     */
    public function getByMonthYear($month, $year);

    /**
     * Get overdue bills
     */
    public function getOverdue();
}
