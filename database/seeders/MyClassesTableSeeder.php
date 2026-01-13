<?php
namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MyClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('my_classes')->delete();
        $ct = ClassType::pluck('id')->all();

        // Kenyan CBC System - Small school currently goes to Grade 4
        // Planning for expansion up to Pre-Primary 6 (PP6) and beyond
        $data = [
            // Pre-Primary (PP1-PP2) - Currently active
            ['name' => 'Pre-Primary 1 (PP1)', 'class_type_id' => $ct[0]],
            ['name' => 'Pre-Primary 2 (PP2)', 'class_type_id' => $ct[0]],
            
            // Lower Primary (Grade 1-3) - Currently active
            ['name' => 'Grade 1', 'class_type_id' => $ct[1]],
            ['name' => 'Grade 2', 'class_type_id' => $ct[1]],
            ['name' => 'Grade 3', 'class_type_id' => $ct[1]],
            
            // Upper Primary (Grade 4) - Currently active, school goes up to here
            ['name' => 'Grade 4', 'class_type_id' => $ct[2]],
            
            // Future expansion - Pre-Primary 3-6 (for planning)
            ['name' => 'Pre-Primary 3 (PP3)', 'class_type_id' => $ct[0]],
            ['name' => 'Pre-Primary 4 (PP4)', 'class_type_id' => $ct[0]],
            ['name' => 'Pre-Primary 5 (PP5)', 'class_type_id' => $ct[0]],
            ['name' => 'Pre-Primary 6 (PP6)', 'class_type_id' => $ct[0]],
            
            // Future expansion - Complete Primary (Grade 5-6)
            ['name' => 'Grade 5', 'class_type_id' => $ct[2]],
            ['name' => 'Grade 6', 'class_type_id' => $ct[2]],
        ];

        DB::table('my_classes')->insert($data);

    }
}
