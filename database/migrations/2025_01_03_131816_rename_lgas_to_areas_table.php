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
        Schema::rename('lgas', 'areas');

        // Update the foreign key relationship
        Schema::table('areas', function (Blueprint $table) {
            // Drop the old foreign key constraint
           // $table->dropForeign(['state_id']);
            
            // Rename the column if needed
            $table->renameColumn('state_id', 'county_id');  
            
            // Add the new foreign key referencing the renamed `counties` table
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::rename('areas', 'lgas');
    }
};
