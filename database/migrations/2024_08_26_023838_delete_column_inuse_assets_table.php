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
        Schema::table('assets', function (Blueprint $table) {
            // Modify the enum column to remove the 'in use' status
            $table->enum('status', ['available', 'damaged', 'unavailable'])
                ->default('available')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Revert the status column to the previous enum values, including 'in use'
            $table->enum('status', ['available', 'in use', 'damaged'])
                ->default('available')
                ->change();
        });
    }

};
