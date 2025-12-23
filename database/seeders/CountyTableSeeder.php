<?php
namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountyTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('counties')->delete();

        $counties = [
            "Kajiado",
        ];

        foreach ($counties as $county) {
            County::create(['name' => $county]);
        }
    }

}
