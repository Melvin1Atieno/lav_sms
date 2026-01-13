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
        Schema::table('student_records', function (Blueprint $table) {
            $table->string('nemis_number')->nullable()->after('adm_no');
            $table->string('previous_school')->nullable()->after('nemis_number');
            $table->string('birth_certificate_path')->nullable()->after('previous_school');
            $table->boolean('admission_fee_paid')->default(false)->after('birth_certificate_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropColumn(['nemis_number', 'previous_school', 'birth_certificate_path', 'admission_fee_paid']);
        });
    }
};
