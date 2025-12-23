<?php
namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AreaTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('areas')->delete();

        $county_id = [1, 1, 1];

        $areas = ["Maasai Mara Estate", "Maziwa", "Maduka Ya Juu",];

        for($i=0; $i<count($areas); $i++){
            Area::create(['county_id' => $county_id[$i], 'name' => $areas[$i]]);
        }
    }

}
