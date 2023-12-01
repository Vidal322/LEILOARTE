<?php

namespace App\Policies;

use App\Models\FAQ;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class FAQPolicy
{
    use HandlesAuthorization;

    public function create()
    {
        return Auth::check() && Auth::user()->type == 'admin';
    }

    public function edit() {
        return Auth::check() && Auth::user()->type == 'admin';
    }

    public function delete()
    {
        return Auth::check() && Auth::user()->type == 'admin';
    }

}