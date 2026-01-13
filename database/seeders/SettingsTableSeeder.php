<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        // Kenyan school settings - Kajiado County, Kajiado Central
        // Kenyan academic year: January to December (3 terms)
        $data = [
            ['type' => 'current_session', 'description' => '2025'],
            ['type' => 'system_title', 'description' => 'St Joans Prep'],
            ['type' => 'system_name', 'description' => 'St Joans Preparatory School - Kajiado'],
            ['type' => 'term_ends', 'description' => '31/12/2025'],
            ['type' => 'term_begins', 'description' => '6/1/2025'],
            ['type' => 'phone', 'description' => '0718578008'],
            ['type' => 'address', 'description' => 'Maasai Mara Estate, Kajiado Central, Kajiado County, Kenya'],
            ['type' => 'system_email', 'description' => 'info@stjoansprep-kajiado.ac.ke'],
            ['type' => 'alt_email', 'description' => 'admin@stjoansprep-kajiado.ac.ke'],
            ['type' => 'email_host', 'description' => ''],
            ['type' => 'email_pass', 'description' => ''],
            ['type' => 'lock_exam', 'description' => 0],
            ['type' => 'logo', 'description' => ''],
        ];

        DB::table('settings')->insert($data);

    }
}
