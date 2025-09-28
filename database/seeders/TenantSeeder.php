<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Flat;
use Carbon\Carbon;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get occupied flats to assign tenants
        $occupiedFlats = Flat::where('is_occupied', true)->get();

        $tenantProfiles = [
            [
                'name' => 'Aarav Sharma',
                'email' => 'aarav.sharma@techcorp.com',
                'phone' => '+91-9876543301',
                'address' => 'H.No 15, Sector 21, Gurgaon, Haryana',
                'emergency_contact' => 'Father: Rajesh Sharma, +91-9876543302',
            ],
            [
                'name' => 'Priya Mehta',
                'email' => 'priya.mehta@gmail.com',
                'phone' => '+91-9876543303',
                'address' => 'Flat 204, Sunrise Apartments, Pune, Maharashtra',
                'emergency_contact' => 'Sister: Kavya Mehta, +91-9876543304',
            ],
            [
                'name' => 'Rohit Verma',
                'email' => 'rohit.verma@infosys.com',
                'phone' => '+91-9876543305',
                'address' => 'Villa 12, Green City, Noida, UP',
                'emergency_contact' => 'Wife: Sonia Verma, +91-9876543306',
            ],
            [
                'name' => 'Sneha Patel',
                'email' => 'sneha.patel@wipro.com',
                'phone' => '+91-9876543307',
                'address' => 'A-101, Crystal Heights, Ahmedabad, Gujarat',
                'emergency_contact' => 'Brother: Kiran Patel, +91-9876543308',
            ],
            [
                'name' => 'Vikash Singh',
                'email' => 'vikash.singh@tcs.com',
                'phone' => '+91-9876543309',
                'address' => 'Plot 45, Cyber City, Hyderabad, Telangana',
                'emergency_contact' => 'Mother: Sunita Singh, +91-9876543310',
            ],
            [
                'name' => 'Anita Reddy',
                'email' => 'anita.reddy@accenture.com',
                'phone' => '+91-9876543311',
                'address' => '3rd Cross, Jayanagar, Bangalore, Karnataka',
                'emergency_contact' => 'Husband: Ramesh Reddy, +91-9876543312',
            ],
            [
                'name' => 'Karthik Nair',
                'email' => 'karthik.nair@microsoft.com',
                'phone' => '+91-9876543313',
                'address' => 'Tower B-302, Tech Park, Chennai, Tamil Nadu',
                'emergency_contact' => 'Father: Suresh Nair, +91-9876543314',
            ],
            [
                'name' => 'Deepika Joshi',
                'email' => 'deepika.joshi@amazon.com',
                'phone' => '+91-9876543315',
                'address' => 'Apartment 501, Silver Oak, Pune, Maharashtra',
                'emergency_contact' => 'Mother: Usha Joshi, +91-9876543316',
            ],
            [
                'name' => 'Arjun Kumar',
                'email' => 'arjun.kumar@google.com',
                'phone' => '+91-9876543317',
                'address' => 'House 78, Model Town, Delhi',
                'emergency_contact' => 'Brother: Varun Kumar, +91-9876543318',
            ],
            [
                'name' => 'Ritu Agarwal',
                'email' => 'ritu.agarwal@oracle.com',
                'phone' => '+91-9876543319',
                'address' => 'F-204, Eden Gardens, Kolkata, West Bengal',
                'emergency_contact' => 'Husband: Amit Agarwal, +91-9876543320',
            ],
            [
                'name' => 'Manish Gupta',
                'email' => 'manish.gupta@ibm.com',
                'phone' => '+91-9876543321',
                'address' => 'Villa 25, Palm Springs, Goa',
                'emergency_contact' => 'Sister: Pooja Gupta, +91-9876543322',
            ],
            [
                'name' => 'Kavitha Rao',
                'email' => 'kavitha.rao@cognizant.com',
                'phone' => '+91-9876543323',
                'address' => 'C-Block 401, Rainbow Residency, Kochi, Kerala',
                'emergency_contact' => 'Father: Mohan Rao, +91-9876543324',
            ],
        ];

        foreach ($occupiedFlats as $index => $flat) {
            if ($index >= count($tenantProfiles)) {
                break; // Don't exceed available tenant profiles
            }

            $profile = $tenantProfiles[$index];

            // Generate lease dates
            $leaseStartDate = Carbon::now()->subMonths(rand(1, 18)); // Started 1-18 months ago
            $leaseEndDate = $leaseStartDate->copy()->addYear(); // 1 year lease

            // Security deposit usually 2-3 times the rent
            $securityDeposit = $flat->rent_amount * rand(2, 3);

            Tenant::create([
                'flat_id' => $flat->id,
                'name' => $profile['name'],
                'email' => $profile['email'],
                'phone' => $profile['phone'],
                'permanent_address' => $profile['address'],
                'lease_start_date' => $leaseStartDate,
                'lease_end_date' => $leaseEndDate,
                'security_deposit' => $securityDeposit,
                'emergency_contact' => $profile['emergency_contact'],
                'is_active' => rand(0, 100) < 95, // 95% active tenants
            ]);
        }

        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();

        $this->command->info('Tenants seeded successfully!');
        $this->command->info("Created {$totalTenants} tenants for occupied flats.");
        $this->command->info("Active tenants: {$activeTenants}/{$totalTenants}");
    }
}
