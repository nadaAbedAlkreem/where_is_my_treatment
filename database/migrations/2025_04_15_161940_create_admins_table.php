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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->foreignId('parent_admin_id')->nullable()->constrained('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image')->nullable()->index();
            $table->enum('status', ['active', 'blocked'])->default('active');
            $table->enum('status_approved_for_pharmacy', ['approved', 'pending', 'reject'])->nullable()->default(null);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes column
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
