<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Flat;

class FlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::all();

        foreach ($buildings as $building) {
            // Create flats for each floor
            for ($floor = 1; $floor <= $building->total_floors; $floor++) {
                // Create 2-4 flats per floor based on building size
                $flatsPerFloor = $building->total_floors > 10 ? 4 : ($building->total_floors > 6 ? 3 : 2);

                for ($flatNum = 1; $flatNum <= $flatsPerFloor; $flatNum++) {
                    $flatNumber = $floor . str_pad($flatNum, 2, '0', STR_PAD_LEFT);

                    // Vary apartment configurations
                    $configs = [
                        ['bedrooms' => 1, 'bathrooms' => 1, 'area' => 650, 'rent' => 15000],
                        ['bedrooms' => 2, 'bathrooms' => 2, 'area' => 900, 'rent' => 22000],
                        ['bedrooms' => 2, 'bathrooms' => 2, 'area' => 1100, 'rent' => 28000],
                        ['bedrooms' => 3, 'bathrooms' => 2, 'area' => 1350, 'rent' => 35000],
                        ['bedrooms' => 3, 'bathrooms' => 3, 'area' => 1500, 'rent' => 42000],
                    ];

                    $config = $configs[array_rand($configs)];

                    // Generate owner details (these are flat owners, not tenants)
                    $ownerNames = [
                        'Ramesh Gupta', 'Sita Devi', 'Krishna Prasad', 'Lakshmi Naidu',
                        'Suresh Chandra', 'Radha Krishnan', 'Mohan Lal', 'Geetha Rao',
                        'Venkat Reddy', 'Saraswati Sharma', 'Gopal Singh', 'Meera Joshi'
                    ];

                    $isOccupied = rand(0, 100) < 70; // 70% occupancy rate

                    Flat::create([
                        'building_id' => $building->id,
                        'flat_number' => $flatNumber,
                        'floor' => $floor,
                        'bedrooms' => $config['bedrooms'],
                        'bathrooms' => $config['bathrooms'],
                        'rent_amount' => $config['rent'] + rand(-3000, 5000), // Add some variation
                        'area_sqft' => $config['area'] + rand(-50, 100),
                        'owner_name' => $ownerNames[array_rand($ownerNames)],
                        'owner_phone' => '+91-' . rand(7000000000, 9999999999),
                        'owner_email' => strtolower(str_replace(' ', '.', $ownerNames[array_rand($ownerNames)])) . '@gmail.com',
                        'owner_address' => 'Owner Address ' . $flatNumber . ', ' . $building->city,
                        'is_occupied' => $isOccupied,
                    ]);
                }
            }
        }

        $totalFlats = Flat::count();
        $occupiedFlats = Flat::where('is_occupied', true)->count();

        $this->command->info('Flats seeded successfully!');
        $this->command->info("Created {$totalFlats} flats across all buildings.");
        $this->command->info("Occupancy rate: {$occupiedFlats}/{$totalFlats} (" . round(($occupiedFlats/$totalFlats)*100, 1) . "%)");
    }
}
