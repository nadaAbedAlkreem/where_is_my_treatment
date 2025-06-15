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
        Schema::table('locations', function (Blueprint $table) {
            $table->decimal('latitude', 10, 6)->change();
            $table->decimal('longitude', 10, 6)->change();
            $table->text('formatted_address')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('region')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('postal_code')->nullable()->change();
            $table->string('location_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
