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

        $data = [
            ['type' => 'current_session', 'description' => '2025'],
            ['type' => 'system_title', 'description' => 'St Joans Prep'],
            ['type' => 'system_name', 'description' => 'St Joans Preparatory'],
            ['type' => 'term_ends', 'description' => '4/4/2025'],
            ['type' => 'term_begins', 'description' => '6/1/2025'],
            ['type' => 'phone', 'description' => '0718578008'],
            ['type' => 'address', 'description' => 'Maasai Mara Estate'],
            ['type' => 'system_email', 'description' => 'support@st-joan.com'],
            ['type' => 'alt_email', 'description' => ''],
            ['type' => 'email_host', 'description' => ''],
            ['type' => 'email_pass', 'description' => ''],
            ['type' => 'lock_exam', 'description' => 0],
            ['type' => 'logo', 'description' => ''],
        ];

        DB::table('settings')->insert($data);

    }
}
