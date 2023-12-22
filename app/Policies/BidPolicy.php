<?php

namespace App\Policies;

use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class BidPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Bid $bid)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $auction_id)
    {
        $auction = Auction::with('bids')->find($auction_id);
        $topBid = $auction->bids()->orderBy('amount', 'desc')->first();
        if (!$auction) {
            return false;
        }
        if (!$auction->active) {
            return false;
        }
        if (($user->type == 'admin')) {
            return false;

        }
        if (($topBid == null) || ($user->id == $topBid->user_id)) {
            return false;
        }
        return true;
    }



    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Bid $bid)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Bid $bid)
    {
        return $user->type=='admin';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Bid $bid)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bid  $bid
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Bid $bid)
    {
        return $user->type=='admin';
    }


    public function bid(User $user, Bid $topBid, Auction $auction, float $amount)
    {
        log::info('bid policy bid');
        if ($auction->active && !($user->type == 'admin') && ($user->id != $topBid->user_id) && ($user->id != $auction->owner_id)
            && ($user->credit >= $amount) && ($amount > $topBid->amount)) {
            log::info('true');
            return true;
        }
        return false;
    }
}
