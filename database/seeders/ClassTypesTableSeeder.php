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

        $data = [
            ['name' => 'Pre Primary', 'code' => 'Pre-Pri'],
            ['name' => 'Lower Primary', 'code' => 'Low-Pri'],
            ['name' => 'Upper Primary', 'code' => 'Uppr-Pri'],
            ['name' => 'Junior Secondary', 'code' => 'Jnr-Sec'],

        ];

        DB::table('class_types')->insert($data);

    }
}
