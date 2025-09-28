<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Required fields for tenant registration
            $table->date('date_of_birth')->after('permanent_address');
            $table->string('identification_type')->after('date_of_birth'); // Required: NID, Passport, Driving License
            $table->string('identification_number')->after('identification_type'); // Required: ID number
            $table->string('id_document_image')->after('identification_number'); // Required: ID document image
                        $table->decimal('security_deposit_paid', 10, 2)->after('id_document_image'); // Required: security deposit amount

            // Required lease information
            $table->decimal('monthly_rent', 10, 2)->after('security_deposit_paid'); // Required: monthly rent amount

            // Optional fields
            $table->string('emergency_contact_name')->nullable()->after('monthly_rent');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'identification_type',
                'identification_number',
                'id_document_image',
                'monthly_rent',
                'security_deposit_paid',
                'emergency_contact_name',
                'emergency_contact_phone'
            ]);
        });
    }
};
