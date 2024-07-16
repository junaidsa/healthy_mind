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
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('file_no', 90)->nullable();
            $table->string('registration_date', 250);
            $table->string('first_name', 250);
            $table->string('last_name', 250);
            $table->string('gender', 90);
            $table->date('date_of_birth');
            $table->integer('uid_number')->nullable();
            $table->string('other_id', 90)->nullable();
            $table->integer('mobile_no')->nullable();
            $table->integer('alternative_no')->nullable();
            $table->text('address');
            $table->timestamps();
            $table->softDeletes();

            // Add foreign key constraint for user_id
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
