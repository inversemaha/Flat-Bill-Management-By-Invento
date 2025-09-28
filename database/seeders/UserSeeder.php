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
            'phone' => '+880-1712-000000',
            'address' => 'Admin Office, Gulshan-2, Dhaka-1212, Bangladesh',
            'email_verified_at' => now(),
        ]);

        // Create House Owners
        $houseOwners = [
            [
                'name' => 'Abdullah Al Mamun',
                'email' => 'abdullah.mamun@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+880-1712-111111',
                'address' => 'House 25, Road 27, Gulshan-1, Dhaka-1212',
            ],
            [
                'name' => 'Rashida Khatun',
                'email' => 'rashida.khatun@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+880-1812-222222',
                'address' => 'Flat 8A, Block C, Bashundhara R/A, Dhaka-1229',
            ],
            [
                'name' => 'Mohammad Hasan',
                'email' => 'mohammad.hasan@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+880-1912-333333',
                'address' => 'House 45, Road 32, Dhanmondi, Dhaka-1205',
            ],
            [
                'name' => 'Fatema Begum',
                'email' => 'fatema.begum@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+880-1612-444444',
                'address' => 'House 12, Road 11, Banani, Dhaka-1213',
            ],
            [
                'name' => 'Mizanur Rahman',
                'email' => 'mizan.rahman@example.com',
                'password' => Hash::make('password'),
                'role' => 'house_owner',
                'phone' => '+880-1512-555555',
                'address' => 'House 88, Sector 11, Uttara, Dhaka-1230',
            ],
        ];

        foreach ($houseOwners as $owner) {
            User::create(array_merge($owner, [
                'email_verified_at' => now(),
            ]));
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin credentials: admin@flatmanager.bd / password');
        $this->command->info('House Owner credentials: [any_house_owner_email] / password');
    }
}
