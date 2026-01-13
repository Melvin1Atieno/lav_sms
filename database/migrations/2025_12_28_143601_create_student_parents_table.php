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
        Schema::create('student_parents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_record_id');
            $table->string('relationship'); // 'father', 'mother', 'guardian'
            $table->string('first_name');
            $table->string('last_name');
            $table->string('id_number');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->timestamps();
            
            $table->foreign('student_record_id')->references('id')->on('student_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_parents');
    }
};
