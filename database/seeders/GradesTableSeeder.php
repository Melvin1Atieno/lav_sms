<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->delete();

        $this->createGrades();
    }

    protected function createGrades()
    {

        $d = [
            
            ['name' => '4', 'mark_from' => 70, 'mark_to' => 100, 'remark' => 'Exceeding Expectation'],
            ['name' => '3', 'mark_from' => 50, 'mark_to' => 69, 'remark' => 'Meeting Expectation'],
            ['name' => '2', 'mark_from' => 40, 'mark_to' => 59, 'remark' => 'Approaching Expectation'],
            ['name' => '1', 'mark_from' => 0, 'mark_to' => 39, 'remark' => 'Below Expectation'],
            ['name' => 'A', 'mark_from' => 0, 'mark_to' => 0, 'remark' => 'Absent'],


        ];
        DB::table('grades')->insert($d);
    }
}
