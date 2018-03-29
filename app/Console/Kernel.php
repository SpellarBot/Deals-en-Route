<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Mail;

class Kernel extends ConsoleKernel {




    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
  
  //  $schedule->call('\App\Http\Controllers\Api\v1\NotificationController@couponNotificationFavExpire')->everyMinute();
   // $schedule->call('\App\Http\Controllers\Api\v1\NotificationController@couponNotificationFavLeft')->everyMinute();   
    // $schedule->call('\App\Http\Controllers\Api\v1\StripeController@handleStripeResponse')->everyMinute();
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
