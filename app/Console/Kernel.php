<?php

namespace App\Console;

use Carbon\CarbonInterface;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('report:save', [
             'type' => 'daily'
         ])->daily();
         $schedule->command('report:save', [
             'type' => 'weekly'
         ])->weeklyOn(CarbonInterface::SATURDAY);
         $schedule->command('report:save', [
             'type' => 'monthly'
         ])->monthly();
         $schedule->command('report:save', [
             'type' => 'yearly'
         ])->yearly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
