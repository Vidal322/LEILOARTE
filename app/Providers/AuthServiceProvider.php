<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Models
use App\Models\Bid;

// Policies
use App\Policies\AdminPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      'App\Models\Card' => 'App\Policies\CardPolicy',
      'App\Models\Item' => 'App\Policies\ItemPolicy',
      'App\Models\Bid' => 'App\Policies\BidPolicy',
      'App\Models\Auction' => 'App\Policies\AuctionPolicy',
      'App\Models\User' => 'App\Policies\UserPolicy',
      'App\Models\User' => 'App\Policies\BidPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
