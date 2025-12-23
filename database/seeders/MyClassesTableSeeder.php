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

        $data = [
            ['name' => 'Day Care', 'class_type_id' => $ct[1]],
            ['name' => 'Pre Primary One', 'class_type_id' => $ct[1]],
            ['name' => 'Pre Primary Two', 'class_type_id' => $ct[1]],
            ['name' => 'Grade One', 'class_type_id' => $ct[2]],
            ['name' => 'Grade Two', 'class_type_id' => $ct[2]],
            ['name' => 'Grade Three', 'class_type_id' => $ct[2]],
        ];

        DB::table('my_classes')->insert($data);

    }
}
