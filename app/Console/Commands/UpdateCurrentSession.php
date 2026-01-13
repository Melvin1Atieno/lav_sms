<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class UpdateCurrentSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:update {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the current academic session (e.g., 2026-2027)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->argument('year');
        
        if (!$year) {
            // Auto-generate based on current year
            $currentYear = date('Y');
            $nextYear = $currentYear + 1;
            $academicYear = "{$currentYear}-{$nextYear}";
        } else {
            // Validate format (should be YYYY-YYYY)
            if (!preg_match('/^\d{4}-\d{4}$/', $year)) {
                $this->error('Invalid format. Please use format: YYYY-YYYY (e.g., 2026-2027)');
                return 1;
            }
            $academicYear = $year;
        }

        $setting = Setting::where('type', 'current_session')->first();
        
        if (!$setting) {
            // Create if it doesn't exist
            Setting::create([
                'type' => 'current_session',
                'description' => $academicYear
            ]);
            $this->info("Created current_session setting with value: {$academicYear}");
        } else {
            $oldValue = $setting->description;
            $setting->update(['description' => $academicYear]);
            $this->info("Updated current_session from '{$oldValue}' to '{$academicYear}'");
        }

        return 0;
    }
}
