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
        Schema::table('medication_availability_requests', function (Blueprint $table) {
            $table->foreignId('treatment_id')
                ->constrained('treatments')
                ->onDelete('cascade');

            $table->foreignId('pharmacy_id')->nullable()->change();

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
