<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\User;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get house owners (skip admin)
        $houseOwners = User::where('role', 'house_owner')->get();

        $buildings = [
            [
                'name' => 'Green Park Residential',
                'address' => 'Plot 15, Road 27, Gulshan-1',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1212',
                'total_floors' => 8,
                'description' => 'Modern residential complex with 2 & 3 bedroom apartments, gymnasium, rooftop garden, and children play area.',
            ],
            [
                'name' => 'Bashundhara Heights',
                'address' => 'Block C, Bashundhara Residential Area',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1229',
                'total_floors' => 12,
                'description' => 'Premium high-rise apartments with shopping complex access, mosque, and community hall.',
            ],
            [
                'name' => 'Dhanmondi Paradise',
                'address' => 'Road 32, Dhanmondi, Near Rabindra Sarobar',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1205',
                'total_floors' => 6,
                'description' => 'Luxury apartments with modern amenities, 24/7 security, generator backup, and lift facility.',
            ],
            [
                'name' => 'Banani Twin Towers',
                'address' => 'Road 11, Banani, Near Banani Club',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1213',
                'total_floors' => 10,
                'description' => 'Contemporary living spaces with community center, landscaped gardens, and covered parking.',
            ],
            [
                'name' => 'Uttara Dream Palace',
                'address' => 'Sector 11, Uttara Model Town, Near Airport',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'postal_code' => '1230',
                'total_floors' => 15,
                'description' => 'Modern apartments designed for families with prayer room, rooftop terrace, and commercial area.',
            ],
        ];

        foreach ($buildings as $index => $buildingData) {
            if (isset($houseOwners[$index])) {
                Building::updateOrCreate(
                    [
                        'house_owner_id' => $houseOwners[$index]->id,
                        'name' => $buildingData['name'],
                    ],
                    $buildingData
                );
            }
        }

        $this->command->info('Buildings seeded successfully!');
        $this->command->info('Created ' . count($buildings) . ' buildings for house owners.');
    }
}
