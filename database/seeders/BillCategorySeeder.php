<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BillCategory;
use App\Models\User;

class BillCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all house owners
        $houseOwners = User::where('role', 'house_owner')->get();

        // Default bill categories as per task requirements
        $categories = [
            [
                'name' => 'Electricity',
                'description' => 'Monthly electricity bills including meter reading charges and power consumption.',
            ],
            [
                'name' => 'Gas Bill',
                'description' => 'LPG cylinder charges and pipeline gas connection bills.',
            ],
            [
                'name' => 'Water Bill',
                'description' => 'Municipal water supply charges and borewell maintenance costs.',
            ],
            [
                'name' => 'Utility Charges',
                'description' => 'Common area maintenance, security, cleaning, and other utility services.',
            ],
            [
                'name' => 'Internet & Cable',
                'description' => 'Broadband internet connection and cable TV subscription charges.',
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Building maintenance, elevator service, generator, and common area upkeep.',
            ],
            [
                'name' => 'Parking Charges',
                'description' => 'Monthly parking fees for vehicles in designated parking areas.',
            ],
        ];

        // Create categories for each house owner (use updateOrCreate to prevent duplicates)
        foreach ($houseOwners as $houseOwner) {
            foreach ($categories as $category) {
                BillCategory::updateOrCreate(
                    [
                        'house_owner_id' => $houseOwner->id,
                        'name' => $category['name'],
                    ],
                    [
                        'description' => $category['description'],
                        'is_active' => true,
                    ]
                );
            }
        }

        $totalCategories = BillCategory::count();
        $this->command->info('Bill categories seeded successfully!');
        $this->command->info("Created {$totalCategories} bill categories for all house owners.");
        $this->command->info('Categories: ' . implode(', ', array_column($categories, 'name')));
    }
}
