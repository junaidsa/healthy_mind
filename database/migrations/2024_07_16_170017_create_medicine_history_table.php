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
        Schema::create('medicine_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('medicine_id');
            $table->integer('stock');
            $table->string('batch_no');
            $table->string('status');
            $table->time('time');
            $table->timestamps(); // This adds 'created_at' and 'updated_at' columns
            $table->softDeletes(); // This adds 'deleted_at' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_history');
    }
};
