<?php
namespace Database\Seeders;

use App\Models\MyClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();
        $c = MyClass::pluck('id')->all();

        // Single stream school - one section per class
        // Only create sections for currently active classes (PP1, PP2, Grade 1-4)
        $data = [
            ['name' => 'PP1', 'my_class_id' => $c[0], 'active' => 1], // Pre-Primary 1
            ['name' => 'PP2', 'my_class_id' => $c[1], 'active' => 1], // Pre-Primary 2
            ['name' => 'Grade 1', 'my_class_id' => $c[2], 'active' => 1], // Grade 1
            ['name' => 'Grade 2', 'my_class_id' => $c[3], 'active' => 1], // Grade 2
            ['name' => 'Grade 3', 'my_class_id' => $c[4], 'active' => 1], // Grade 3
            ['name' => 'Grade 4', 'my_class_id' => $c[5], 'active' => 1], // Grade 4
        ];

        DB::table('sections')->insert($data);
    }
}
