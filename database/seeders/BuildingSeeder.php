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
                'name' => 'Green Valley Apartments',
                'address' => 'Plot No. 45, Green Valley Layout, Near Metro Station',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'postal_code' => '560001',
                'total_floors' => 8,
                'description' => 'Modern residential complex with 2 & 3 BHK apartments, gym, swimming pool, and children play area.',
            ],
            [
                'name' => 'Brigade Residency',
                'address' => 'Brigade Road, Commercial Street Area',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'postal_code' => '560025',
                'total_floors' => 12,
                'description' => 'Premium high-rise apartments in the heart of the city with shopping mall access.',
            ],
            [
                'name' => 'Koramangala Heights',
                'address' => '5th Block, Koramangala, Near Forum Mall',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'postal_code' => '560034',
                'total_floors' => 6,
                'description' => 'Luxury apartments with modern amenities, 24x7 security, and power backup.',
            ],
            [
                'name' => 'Indiranagar Towers',
                'address' => '100 Feet Road, Indiranagar, Near CMH Road',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'postal_code' => '560038',
                'total_floors' => 10,
                'description' => 'Contemporary living spaces with club house, landscaped gardens, and parking facilities.',
            ],
            [
                'name' => 'Whitefield Gardens',
                'address' => 'ITPL Main Road, Whitefield, Near Tech Parks',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'postal_code' => '560066',
                'total_floors' => 15,
                'description' => 'IT corridor apartments designed for professionals with modern workspaces and co-working areas.',
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
