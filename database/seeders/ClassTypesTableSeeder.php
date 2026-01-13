<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_types')->delete();

        // Kenyan CBC System: 2-6-3-3-3
        // 2 Pre-Primary, 6 Primary, 3 Junior Secondary, 3 Senior Secondary, 3 University
        $data = [
            ['name' => 'Pre-Primary', 'code' => 'PP'],
            ['name' => 'Lower Primary (Grade 1-3)', 'code' => 'LP'],
            ['name' => 'Upper Primary (Grade 4-6)', 'code' => 'UP'],
            ['name' => 'Junior Secondary (Grade 7-9)', 'code' => 'JS'],
            ['name' => 'Senior Secondary (Grade 10-12)', 'code' => 'SS'],
        ];

        DB::table('class_types')->insert($data);

    }
}
