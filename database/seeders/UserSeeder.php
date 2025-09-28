<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@flatmanager.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+91-9876543210',
            'address' => 'Admin Office, Tech Park, Bangalore, Karnataka',
            'email_verified_at' => now(),
        ]);

        // Create House Owners
        $houseOwners = [
            [
                'name' => 'Rajesh Kumar',
                'email' => 'rajesh.kumar@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+91-9876543211',
                'address' => '123, MG Road, Bangalore, Karnataka, 560001',
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+91-9876543212',
                'address' => '456, Brigade Road, Bangalore, Karnataka, 560025',
            ],
            [
                'name' => 'Amit Patel',
                'email' => 'amit.patel@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+91-9876543213',
                'address' => '789, Koramangala, Bangalore, Karnataka, 560034',
            ],
            [
                'name' => 'Sunita Reddy',
                'email' => 'sunita.reddy@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+91-9876543214',
                'address' => '321, Indiranagar, Bangalore, Karnataka, 560038',
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram.singh@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+91-9876543215',
                'address' => '654, Whitefield, Bangalore, Karnataka, 560066',
            ],
        ];

        foreach ($houseOwners as $owner) {
            User::create(array_merge($owner, [
                'email_verified_at' => now(),
            ]));
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin credentials: admin@flatmanager.com / password');
        $this->command->info('House Owner credentials: [any_house_owner_email] / password');
    }
}
