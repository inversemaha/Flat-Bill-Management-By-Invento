<?php

namespace App\Services;

use App\Contracts\BillRepositoryInterface;
use App\Mail\BillCreatedMail;
use App\Mail\BillPaidMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
        $data['status'] = $data['status'] ?? 'unpaid';
        
        // Create the bill
        $bill = $this->repository->create($data);
        
        // Send notification email
        try {
            $this->sendBillCreatedNotification($bill);
        } catch (\Exception $e) {
            Log::error('Failed to send bill created notification', [
                'bill_id' => $bill->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return $bill;
    }

    /**
     * Get bills with filters
     */
    public function getBillsWithFilters(array $filters = [])
    {
        $query = $this->repository->with(['flat', 'flat.building', 'flat.building.houseOwner', 'billCategory', 'tenant']);

        // Apply filters if provided
        if (!empty($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }

        if (!empty($filters['flat_id'])) {
            $query = $query->where('flat_id', $filters['flat_id']);
        }

        if (!empty($filters['category_id'])) {
            $query = $query->where('bill_category_id', $filters['category_id']);
        }

        if (!empty($filters['month'])) {
            $query = $query->where('month', $filters['month']);
        }

        if (!empty($filters['year'])) {
            $query = $query->where('year', $filters['year']);
        }

        return $query->all();
    }

    /**
     * Find bill by ID with all details
     */
    public function findByIdWithDetails($id)
    {
        return $this->repository->with(['flat', 'flat.building', 'flat.building.houseOwner', 'billCategory', 'tenant'])->find($id);
    }

    /**
     * Mark bill as paid
     */
    public function markAsPaid($id, array $paymentDetails = [])
    {
        $bill = $this->findByIdWithDetails($id);
        
        if (!$bill) {
            throw new \Exception('Bill not found');
        }

        if ($bill->status === 'paid') {
            throw new \Exception('Bill is already paid');
        }

        // Update bill status
        $updateData = [
            'status' => 'paid',
            'paid_date' => now()
        ];

        // Add payment details if provided
        if (!empty($paymentDetails['payment_details'])) {
            $updateData['payment_details'] = $paymentDetails['payment_details'];
        }

        $updatedBill = $this->repository->update($id, $updateData);
        
        // Reload with relationships
        $billWithDetails = $this->findByIdWithDetails($id);
        
        // Send notification email
        try {
            $this->sendBillPaidNotification($billWithDetails);
        } catch (\Exception $e) {
            Log::error('Failed to send bill paid notification', [
                'bill_id' => $billWithDetails->id,
                'error' => $e->getMessage()
            ]);
        }

        return $billWithDetails;
    }

    /**
     * Generate monthly bills for all active flats in a building
     */
    public function generateMonthlyBills($buildingId, $month, $year, $categoryId)
    {
        $billsCreated = 0;
        
        DB::transaction(function () use ($buildingId, $month, $year, $categoryId, &$billsCreated) {
            // Get all flats in the building that are occupied
            $flats = \App\Models\Flat::where('building_id', $buildingId)
                ->where('is_occupied', true)
                ->whereHas('tenant') // Only flats with active tenants
                ->get();

            foreach ($flats as $flat) {
                // Check if bill already exists for this month/year/category
                $existingBill = \App\Models\Bill::where('flat_id', $flat->id)
                    ->where('bill_category_id', $categoryId)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

                if (!$existingBill) {
                    // Get bill category to get default amount
                    $category = \App\Models\BillCategory::find($categoryId);
                    
                    // Create new bill
                    $billData = [
                        'flat_id' => $flat->id,
                        'bill_category_id' => $categoryId,
                        'month' => $month,
                        'year' => $year,
                        'amount' => $category->default_amount ?? 0,
                        'due_amount' => 0, // Will be calculated based on previous unpaid bills
                        'status' => 'unpaid',
                        'due_date' => now()->addDays(30), // 30 days from now
                        'notes' => "Auto-generated monthly bill for {$category->name}"
                    ];

                    // Calculate due amount from previous unpaid bills
                    $previousDues = \App\Models\Bill::where('flat_id', $flat->id)
                        ->where('status', '!=', 'paid')
                        ->where(function($query) use ($month, $year) {
                            $query->where('year', '<', $year)
                                  ->orWhere(function($q) use ($month, $year) {
                                      $q->where('year', '=', $year)
                                        ->where('month', '<', $month);
                                  });
                        })
                        ->sum('total_amount');

                    $billData['due_amount'] = $previousDues;
                    $billData['total_amount'] = $billData['amount'] + $billData['due_amount'];

                    $this->createBill($billData);
                    $billsCreated++;
                }
            }
        });

        return $billsCreated;
    }

    /**
     * Send bill created notification
     */
    public function sendBillCreatedNotification($bill)
    {
        // Load relationships if not already loaded
        if (!$bill->relationLoaded('flat')) {
            $bill = $this->findByIdWithDetails($bill->id);
        }

        // Get recipient emails
        $recipients = [];

        // Add tenant email if exists
        if ($bill->tenant && $bill->tenant->email) {
            $recipients[] = $bill->tenant->email;
        }

        // Add house owner email
        if ($bill->flat && $bill->flat->building && $bill->flat->building->houseOwner) {
            $houseOwner = $bill->flat->building->houseOwner;
            if ($houseOwner->email) {
                $recipients[] = $houseOwner->email;
            }
        }

        // Send emails
        foreach (array_unique($recipients) as $email) {
            Mail::to($email)->send(new BillCreatedMail($bill));
        }

        // Also send to admin if configured
        if (config('mail.admin_notifications', false)) {
            $adminEmails = \App\Models\User::where('role', 'admin')
                ->whereNotNull('email')
                ->pluck('email')
                ->toArray();

            foreach ($adminEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new BillCreatedMail($bill));
            }
        }

        Log::info('Bill created notification sent', [
            'bill_id' => $bill->id,
            'recipients' => $recipients
        ]);

        return true;
    }

    /**
     * Send bill paid notification
     */
    public function sendBillPaidNotification($bill)
    {
        // Load relationships if not already loaded
        if (!$bill->relationLoaded('flat')) {
            $bill = $this->findByIdWithDetails($bill->id);
        }

        // Get recipient emails
        $recipients = [];

        // Add house owner email (primary recipient for payment notifications)
        if ($bill->flat && $bill->flat->building && $bill->flat->building->houseOwner) {
            $houseOwner = $bill->flat->building->houseOwner;
            if ($houseOwner->email) {
                $recipients[] = $houseOwner->email;
            }
        }

        // Send emails
        foreach (array_unique($recipients) as $email) {
            Mail::to($email)->send(new BillPaidMail($bill));
        }

        // Also send to admin if configured
        if (config('mail.admin_notifications', false)) {
            $adminEmails = \App\Models\User::where('role', 'admin')
                ->whereNotNull('email')
                ->pluck('email')
                ->toArray();

            foreach ($adminEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new BillPaidMail($bill));
            }
        }

        Log::info('Bill paid notification sent', [
            'bill_id' => $bill->id,
            'recipients' => $recipients
        ]);

        return true;
    }

    /**
     * Get overdue bills
     */
    public function getOverdueBills()
    {
        return $this->repository
            ->with(['flat', 'flat.building', 'flat.building.houseOwner', 'billCategory', 'tenant'])
            ->where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->all();
    }

    /**
     * Get bills summary for a house owner
     */
    public function getBillsSummaryForHouseOwner($houseOwnerId)
    {
        $bills = \App\Models\Bill::whereHas('flat.building', function ($query) use ($houseOwnerId) {
            $query->where('house_owner_id', $houseOwnerId);
        })->get();

        return [
            'total_bills' => $bills->count(),
            'paid_bills' => $bills->where('status', 'paid')->count(),
            'unpaid_bills' => $bills->where('status', 'unpaid')->count(),
            'overdue_bills' => $bills->where('status', '!=', 'paid')
                ->where('due_date', '<', now())->count(),
            'total_amount_due' => $bills->where('status', '!=', 'paid')->sum('total_amount'),
            'total_amount_collected' => $bills->where('status', 'paid')->sum('total_amount'),
        ];
    }
}
