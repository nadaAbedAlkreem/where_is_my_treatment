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
        Schema::create('pharmacy_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained('treatments')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->boolean('discount');
            $table->decimal('discount_rate', 10, 2)->nullable();
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->integer('quantity');
            $table->boolean('is_expired')->default(false);
            $table->date('expiration_date');
            $table->timestamps();
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_stocks');
    }
};
