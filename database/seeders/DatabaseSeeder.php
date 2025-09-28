<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Seed in correct order due to foreign key dependencies
        $this->call([
            UserSeeder::class,           // Create admin and house owners first
            BuildingSeeder::class,       // Create buildings for house owners
            FlatSeeder::class,          // Create flats in buildings
            BillCategorySeeder::class,  // Create bill categories for house owners
            TenantSeeder::class,        // Assign tenants to occupied flats
            BillSeeder::class,          // Create bills for flats with tenants
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('   Admin: admin@flatmanager.bd / password');
        $this->command->info('   House Owners: [check UserSeeder output] / password');
        $this->command->info('');
        $this->command->info('📊 Seeded Data Summary:');
        $this->command->info('   • Users (Admin + House Owners)');
        $this->command->info('   • Buildings with multi-tenant isolation');
        $this->command->info('   • Flats with realistic occupancy rates');
        $this->command->info('   • Bill categories (Electricity, Gas, Water, etc.)');
        $this->command->info('   • Tenants assigned to occupied flats');
        $this->command->info('   • Bills with various payment statuses');
    }
}
