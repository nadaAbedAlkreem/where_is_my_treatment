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
        Schema::create('request_treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('medication_availability_requests')->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained('treatments')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_treatments');
    }
};
