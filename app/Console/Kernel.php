<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TwitterSync::class,
        Commands\FlickrSync::class,
        Commands\RssSync::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Commands\TwitterSync::class)->everyTenMinutes();
        $schedule->command(Commands\FlickerSync::class)->hourly();
        $schedule->command(Commands\RssSync::class)->everyTenMinutes();
        
        $schedule->call(function () {
            
            $threeDays = date('Y-m-d', time() - (3 * 24 * 60 * 60)).' 00:00:00'; 
//$q->where('created_at', '>=', date('Y-m-d').' 00:00:00'));
            
            DB::table('users')->where([
                ['status', '=', 'inactive'],
                ['created_at', '<=', $threeDays],
            ])->delete();         
            //DB::table('recent_users')
        })->weekly();        
        
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
