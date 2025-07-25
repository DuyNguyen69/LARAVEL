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
        Schema::table('rentals', function (Blueprint $table) {
            $table->renameColumn('start_date', 'pickup_date');
            $table->renameColumn('end_date', 'dropoff_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->renameColumn('pickup_date', 'start_date');
            $table->renameColumn('dropoff_date', 'end_date');
        });
    }
};
