<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('empleado:sync')->twiceDaily(1, 13);
        $schedule->command('cargos:sync')->twiceDaily(1, 13);
        $schedule->command('areas:sync')->twiceDaily(1, 13);
        $schedule->command('centros:sync')->twiceDaily(1, 13);
        $schedule->command('empleadoina:sync')->twiceDaily(1, 13);
        /* $schedule->command('centros:sync')->everyMinute();
        $schedule->command('areas:sync')->everyMinute();
        $schedule->command('cargos:sync')->everyMinute();
        $schedule->command('empleado:sync')->everyMinute();
        $schedule->command('empleadoina:sync')->everyMinute(); */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
