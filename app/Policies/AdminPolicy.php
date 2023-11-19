<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bid;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    // verifies if the user is an admin
    public function bid(User $user)
    {   
        return  !($user->type == 'admin');
    }
}
