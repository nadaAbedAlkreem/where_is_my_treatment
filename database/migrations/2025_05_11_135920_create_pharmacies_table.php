<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins');
            $table->string('name_pharmacy');
            $table->string('image_pharmacy');
            $table->string('license_number');
            $table->string('license_file_path');
            $table->timestamp('license_expiry_date');
            $table->string('phone_number_pharmacy', 20);
            $table->string('email_pharmacy');
            $table->enum('status_exist', ['open', 'closed'])->default('open');
            $table->text('description');
            $table->string('working_hours');
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
