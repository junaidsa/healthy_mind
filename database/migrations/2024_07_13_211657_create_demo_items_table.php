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
        Schema::create('demo_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicine_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('page_id');
            $table->string('batch_no', 50);
            $table->decimal('medicine_price',8,2);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('demo_items');
    }
};
