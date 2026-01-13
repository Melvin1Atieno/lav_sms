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

        // Get Kajiado County ID dynamically
        $kajiadoCounty = \App\Models\County::where('name', 'Kajiado')->first();
        
        if (!$kajiadoCounty) {
            // If county doesn't exist, create it
            $kajiadoCounty = \App\Models\County::create(['name' => 'Kajiado']);
        }

        // Kajiado County, Kajiado Central Sub-County areas
        $areas = [
            "Maasai Mara Estate", 
            "Kajiado Central", 
            "Ongata Rongai"
        ];

        foreach ($areas as $area) {
            Area::create(['county_id' => $kajiadoCounty->id, 'name' => $area]);
        }
    }

}
