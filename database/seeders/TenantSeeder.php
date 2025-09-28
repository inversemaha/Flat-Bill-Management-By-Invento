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
                'name' => 'Mohammad Rahman',
                'email' => 'mohammad.rahman@gmail.com',
                'phone' => '+880-1712-345678',
                'address' => 'House 15, Road 27, Gulshan-1, Dhaka-1212',
                'date_of_birth' => '1990-03-15',
                'identification_type' => 'NID',
                'identification_number' => '1234567890123',
                'emergency_contact_name' => 'Abdul Rahman',
                'emergency_contact_phone' => '+880-1712-345679',
            ],
            [
                'name' => 'Fatima Khatun',
                'email' => 'fatima.khatun@yahoo.com',
                'phone' => '+880-1812-345680',
                'address' => 'Flat 5B, Block C, Bashundhara R/A, Dhaka-1229',
                'date_of_birth' => '1988-07-22',
                'identification_type' => 'NID',
                'identification_number' => '2345678901234',
                'emergency_contact_name' => 'Nasir Ahmed',
                'emergency_contact_phone' => '+880-1812-345681',
            ],
            [
                'name' => 'Ahmed Hasan',
                'email' => 'ahmed.hasan@outlook.com',
                'phone' => '+880-1912-345682',
                'address' => 'House 42, Sector 11, Uttara, Dhaka-1230',
                'date_of_birth' => '1985-12-10',
                'identification_type' => 'Passport',
                'identification_number' => 'BD1234567',
                'emergency_contact_name' => 'Rashida Begum',
                'emergency_contact_phone' => '+880-1912-345683',
            ],
            [
                'name' => 'Rashida Begum',
                'email' => 'rashida.begum@hotmail.com',
                'phone' => '+880-1612-345684',
                'address' => 'Apartment 3A, Green View, Dhanmondi, Dhaka-1205',
                'date_of_birth' => '1992-09-18',
                'identification_type' => 'NID',
                'identification_number' => '3456789012345',
                'emergency_contact_name' => 'Karim Uddin',
                'emergency_contact_phone' => '+880-1612-345685',
            ],
            [
                'name' => 'Mizanur Rahman',
                'email' => 'mizan.rahman@gmail.com',
                'phone' => '+880-1512-345686',
                'address' => 'House 78, Road 12, Banani, Dhaka-1213',
                'date_of_birth' => '1987-04-25',
                'identification_type' => 'Driving License',
                'identification_number' => 'DL-456789123',
                'emergency_contact_name' => 'Salma Khatun',
                'emergency_contact_phone' => '+880-1512-345687',
            ],
            [
                'name' => 'Salma Akter',
                'email' => 'salma.akter@gmail.com',
                'phone' => '+880-1412-345688',
                'address' => 'Flat 8C, Paradise Heights, Mirpur DOHS, Dhaka-1216',
                'date_of_birth' => '1991-11-08',
                'identification_type' => 'NID',
                'identification_number' => '4567890123456',
                'emergency_contact_name' => 'Hafiz Ahmed',
                'emergency_contact_phone' => '+880-1412-345689',
            ],
            [
                'name' => 'Karim Uddin',
                'email' => 'karim.uddin@yahoo.com',
                'phone' => '+880-1312-345690',
                'address' => 'House 25, Lane 3, New DOHS, Mohakhali, Dhaka-1206',
                'date_of_birth' => '1986-02-14',
                'identification_type' => 'NID',
                'identification_number' => '5678901234567',
                'emergency_contact_name' => 'Nasreen Akter',
                'emergency_contact_phone' => '+880-1312-345691',
            ],
            [
                'name' => 'Nasreen Akter',
                'email' => 'nasreen.akter@outlook.com',
                'phone' => '+880-1712-345692',
                'address' => 'Apartment 6D, Silver Tower, Lalmatia, Dhaka-1207',
                'date_of_birth' => '1989-08-30',
                'identification_type' => 'Passport',
                'identification_number' => 'BD2345678',
                'emergency_contact_name' => 'Rafiq Hassan',
                'emergency_contact_phone' => '+880-1712-345693',
            ],
            [
                'name' => 'Abdul Karim',
                'email' => 'abdul.karim@gmail.com',
                'phone' => '+880-1812-345694',
                'address' => 'House 33, Road 15, Baridhara DOHS, Dhaka-1212',
                'date_of_birth' => '1984-06-12',
                'identification_type' => 'NID',
                'identification_number' => '6789012345678',
                'emergency_contact_name' => 'Shahin Alam',
                'emergency_contact_phone' => '+880-1812-345695',
            ],
            [
                'name' => 'Rubina Khatun',
                'email' => 'rubina.khatun@hotmail.com',
                'phone' => '+880-1912-345696',
                'address' => 'Flat 4B, Royal Garden, Shantinagar, Dhaka-1217',
                'date_of_birth' => '1993-01-20',
                'identification_type' => 'Driving License',
                'identification_number' => 'DL-567890234',
                'emergency_contact_name' => 'Delwar Hossain',
                'emergency_contact_phone' => '+880-1912-345697',
            ],
            [
                'name' => 'Shahidul Islam',
                'email' => 'shahid.islam@gmail.com',
                'phone' => '+880-1612-345698',
                'address' => 'House 88, Sector 7, Uttara, Dhaka-1230',
                'date_of_birth' => '1988-10-05',
                'identification_type' => 'NID',
                'identification_number' => '7890123456789',
                'emergency_contact_name' => 'Amina Begum',
                'emergency_contact_phone' => '+880-1612-345699',
            ],
            [
                'name' => 'Amina Begum',
                'email' => 'amina.begum@yahoo.com',
                'phone' => '+880-1512-345700',
                'address' => 'Apartment 9A, Dream Palace, Tejgaon, Dhaka-1208',
                'date_of_birth' => '1990-12-28',
                'identification_type' => 'Passport',
                'identification_number' => 'BD3456789',
                'emergency_contact_name' => 'Shahidul Islam',
                'emergency_contact_phone' => '+880-1512-345701',
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

            // Create a dummy image path for ID documents (in a real app, you'd have actual images)
            $idDocumentImage = 'tenant_documents/sample_id_' . ($index + 1) . '.jpg';

            Tenant::create([
                'flat_id' => $flat->id,
                'name' => $profile['name'],
                'email' => $profile['email'],
                'phone' => $profile['phone'],
                'permanent_address' => $profile['address'],
                'date_of_birth' => Carbon::parse($profile['date_of_birth']),
                'identification_type' => $profile['identification_type'],
                'identification_number' => $profile['identification_number'],
                'id_document_image' => $idDocumentImage,
                'lease_start_date' => $leaseStartDate,
                'lease_end_date' => $leaseEndDate,
                'monthly_rent' => $flat->rent_amount,
                'security_deposit_paid' => $securityDeposit,
                'emergency_contact_name' => $profile['emergency_contact_name'],
                'emergency_contact_phone' => $profile['emergency_contact_phone'],
                'is_active' => rand(0, 100) < 95, // 95% active tenants
            ]);
        }

        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();

        $this->command->info('Tenants seeded successfully!');
        $this->command->info("Created {$totalTenants} tenants for occupied flats with Bangladesh data.");
        $this->command->info("Active tenants: {$activeTenants}/{$totalTenants}");
        $this->command->info("ID Document types: NID, Passport, Driving License");
    }
}
