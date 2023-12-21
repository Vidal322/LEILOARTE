<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;
use App\Models\Bid;
use App\Events\AuctionEnded;
use App\Events\AuctionEnding;
use App\Events\AuctionWinner;
use Illuminate\Database\Eloquent\Collection;

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
        // Send notifications and to users that follow auctions that have ended
        // and set the auctions as inactive

        $schedule->call(function () {
            try {
                $endedAuctions = Auction::with(['bids', 'bids.bidder'])
                                        ->where('end_t', '<', now())
                                        ->where('active', true)
                                        ->get();
               foreach ($endedAuctions as $auction) {
                    $auction->update(['active' => false]);
                    $auction->save();

                    $followers = $auction->auctionsSaved();
                    foreach ($followers as $follower) {
                        $user = $follower->user();
                        $notification = new Notification();
                        $notification->user_id = $user->user_id;
                        $notification->date = now();
                        $notification->message = 'The auction ' . $auction->id . ' has ended!';
                        $notification->save();

                        $notificationAuction = new NotificationAuction();
                        $notificationAuction->notification_id = $notification->id;
                        $notificationAuction->auction_id = $auction->id;
                        $notificationAuction->save();
                    }

                    event(new AuctionEnded($auction->id));

                    if ($auction->bids()->count() > 0) {

                    $winner = $auction->bids()->orderBy('amount', 'desc')->first();

                    event(new AuctionWinner($winner->id, $auction->id));

                    $winnerNotification = new Notification();
                    $winnerNotification->user_id = $user->user_id;
                    $winnerNotification->date = now();
                    $winnerNotification->message = 'You won the auction ' . $auction->id . '!';
                    $winnerNotification->save();

                    $winnerNotificationAuction = new NotificationAuction();
                    $winnerNotificationAuction->notification_id = $winnerNotification->id;
                    $winnerNotificationAuction->auction_id = $auction->id;
                    $winnerNotificationAuction->save();
                    }

                }
            }catch (\Exception $e) {
                 // Log the exception
                 \Log::error('Scheduled task failed: ' . $e->getMessage());
            }

        })->everyMinute();


        // Send notifications to users that follow auctions that are ending in 30 minutes

        $schedule->call(function() {
            try {
                $endingAuctions = Auction::where('end_t', '>', now())
                                        ->where('end_t', '<', now()->addMinutes(30))
                                        ->where('active', true)
                                        ->get();
                foreach ($endingAuctions as $auction) {
                    event(new AuctionEnding($auction->id));
                }
            }catch (\Exception $e) {
                 // Log the exception
                 \Log::error('Scheduled task failed: ' . $e->getMessage());
            }
        });
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
