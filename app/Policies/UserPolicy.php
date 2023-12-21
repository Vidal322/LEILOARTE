<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Block;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model) {

        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return !(Auth::check()) || $user->userType == 'admin';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        if ($user->userType == 'admin') {
            return true;
        }
        else if ($user-> id == $model->id && !($user->deleted)) {
            return true;
        }
        return false;
    }

    public function edit(User $user, User $model) {
        return ($user->id == $model->id);
    }

    public function deleteUser(User $user, User $model) {
        return ($user->type == 'admin' || $user->id == $model->id);
    }

    public function block(User $user, User $model)
{
    return $user->type == 'admin';
}

    public function unblock(User $user, User $model) {
        return $user->type == 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
    //
    }

    public function addCredit(User $user, User $model)
    {
        return Auth::check() && $user->id == $model->id;
    }
}
