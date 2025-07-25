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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            // Ai thuê
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Xe nào
            $table->foreignId('car_id')->constrained()->onDelete('cascade');

            $table->date('start_date');     // Ngày bắt đầu thuê
            $table->date('end_date');       // Ngày trả xe

            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
