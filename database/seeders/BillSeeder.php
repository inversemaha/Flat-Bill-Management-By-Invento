<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\BillCategory;
use App\Models\Flat;
use App\Models\Tenant;
use Carbon\Carbon;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get flats with tenants
        $flatsWithTenants = Flat::whereHas('tenants', function ($query) {
            $query->where('is_active', true);
        })->with('tenants', 'building.houseOwner')->get();

        $currentMonth = Carbon::now();

        foreach ($flatsWithTenants as $flat) {
            // Get bill categories for this flat's house owner
            $billCategories = BillCategory::where('house_owner_id', $flat->building->house_owner_id)
                                        ->where('is_active', true)
                                        ->get();

            // Generate bills for the last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $billMonth = $currentMonth->copy()->subMonths($i);
                $monthString = $billMonth->format('Y-m');
                $year = $billMonth->year;

                foreach ($billCategories as $category) {
                    $amount = $this->getBillAmount($category->name, $flat);
                    $dueAmount = 0;

                    // Add due amount for some bills (unpaid bills)
                    if (rand(0, 100) < 20) { // 20% chance of having dues
                        $dueAmount = rand(500, 2000);
                    }

                    $totalAmount = $amount + $dueAmount;
                    $status = $this->getBillStatus($i); // Recent bills more likely to be unpaid

                    $dueDate = $billMonth->copy()->addDays(15); // Due 15 days after month start
                    $paidDate = null;
                    $paymentDetails = null;

                    if ($status === 'paid') {
                        $paidDate = $dueDate->copy()->subDays(rand(1, 10)); // Paid before due date
                        $paymentDetails = json_encode([
                            'payment_method' => ['UPI', 'Net Banking', 'Credit Card', 'Cash'][rand(0, 3)],
                            'transaction_id' => 'TXN' . rand(100000, 999999),
                            'payment_date' => $paidDate->format('Y-m-d H:i:s')
                        ]);
                    } elseif ($status === 'partially_paid') {
                        $paidDate = $dueDate->copy()->addDays(rand(1, 5)); // Paid after due date
                        $paymentDetails = json_encode([
                            'payment_method' => 'UPI',
                            'partial_amount' => round($totalAmount * 0.7, 2),
                            'transaction_id' => 'TXN' . rand(100000, 999999),
                            'payment_date' => $paidDate->format('Y-m-d H:i:s')
                        ]);
                    }

                    Bill::create([
                        'flat_id' => $flat->id,
                        'bill_category_id' => $category->id,
                        'month' => $monthString,
                        'year' => $year,
                        'amount' => $amount,
                        'due_amount' => $dueAmount,
                        'total_amount' => $totalAmount,
                        'status' => $status,
                        'due_date' => $dueDate,
                        'paid_date' => $paidDate,
                        'notes' => $this->getBillNotes($category->name, $status),
                        'payment_details' => $paymentDetails,
                    ]);
                }
            }
        }

        $totalBills = Bill::count();
        $paidBills = Bill::where('status', 'paid')->count();
        $unpaidBills = Bill::where('status', 'unpaid')->count();
        $partialBills = Bill::where('status', 'partially_paid')->count();

        $this->command->info('Bills seeded successfully!');
        $this->command->info("Created {$totalBills} bills across all flats and categories.");
        $this->command->info("Status breakdown: Paid: {$paidBills}, Unpaid: {$unpaidBills}, Partial: {$partialBills}");
    }

    /**
     * Get bill amount based on category and flat
     */
    private function getBillAmount(string $categoryName, Flat $flat): float
    {
        $baseAmounts = [
            'Electricity' => rand(800, 2500),
            'Gas Bill' => rand(400, 800),
            'Water Bill' => rand(300, 600),
            'Utility Charges' => rand(1500, 3000),
            'Internet & Cable' => rand(800, 1200),
            'Maintenance' => round($flat->rent_amount * 0.1), // 10% of rent
            'Parking Charges' => rand(500, 1000),
        ];

        return $baseAmounts[$categoryName] ?? rand(500, 1500);
    }

    /**
     * Get bill status based on how recent the bill is
     */
    private function getBillStatus(int $monthsBack): string
    {
        if ($monthsBack <= 1) {
            // Current and last month - more likely to be unpaid
            $statuses = ['paid' => 50, 'unpaid' => 40, 'partially_paid' => 10];
        } elseif ($monthsBack <= 3) {
            // 2-3 months back - mostly paid
            $statuses = ['paid' => 80, 'unpaid' => 15, 'partially_paid' => 5];
        } else {
            // Older bills - almost all paid
            $statuses = ['paid' => 95, 'unpaid' => 3, 'partially_paid' => 2];
        }

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($statuses as $status => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                return $status;
            }
        }

        return 'paid';
    }

    /**
     * Get bill notes based on category and status
     */
    private function getBillNotes(string $categoryName, string $status): ?string
    {
        $notes = [
            'Electricity' => [
                'paid' => 'Payment received on time. Meter reading: ' . rand(1000, 9999),
                'unpaid' => 'Pending payment. Final notice sent.',
                'partially_paid' => 'Partial payment received. Balance amount pending.',
            ],
            'Gas Bill' => [
                'paid' => 'LPG cylinder delivered and payment confirmed.',
                'unpaid' => 'Payment overdue. Service may be disconnected.',
                'partially_paid' => 'Partial payment received for gas connection.',
            ],
            'Water Bill' => [
                'paid' => 'Water bill paid for the month.',
                'unpaid' => 'Water bill payment pending.',
                'partially_paid' => 'Partial water bill payment received.',
            ],
            'Utility Charges' => [
                'paid' => 'Maintenance and utility charges paid.',
                'unpaid' => 'Utility charges pending. Includes maintenance and security.',
                'partially_paid' => 'Partial utility payment received.',
            ],
        ];

        return $notes[$categoryName][$status] ?? null;
    }
}
