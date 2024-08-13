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
        Schema::create('assets', function (Blueprint $table) {
            $table->id(); // Primary Key (id)
            $table->string('name'); // Asset name
            $table->integer('quantity'); // Quantity
            $table->enum('status', ['available', 'in use', 'damaged']); // Status (available, in use, damaged)
            $table->text('description')->nullable(); // Description
            $table->timestamps(); // Created and updated timestamps
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }

};
