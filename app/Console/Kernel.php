<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;

class Kernel extends ConsoleKernel
{
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
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            try {
                info('Scheduled task is running.');
                $endedAuctions = Auction::where('end_date', '<', now())
                                        ->where('active', true)
                                        ->get();
                foreach ($endedAuctions as $auction) {
                    $auction->update(['active' => false]);
                    $auction->save();
                    event(new AuctionEnded($auction->id));
                }
            } catch (\Exception $e) {
                // Log the exception
                \Log::error('Scheduled task failed: ' . $e->getMessage());
            }
        })->everyMinute();
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
