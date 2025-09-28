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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->string('flat_number');
            $table->integer('floor');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('rent_amount', 10, 2)->nullable();
            $table->decimal('area_sqft', 8, 2)->nullable();

            // Flat owner details (not tenant - this is the flat owner)
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('owner_email')->nullable();
            $table->text('owner_address')->nullable();

            $table->boolean('is_occupied')->default(false);
            $table->timestamps();

            $table->unique(['building_id', 'flat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
