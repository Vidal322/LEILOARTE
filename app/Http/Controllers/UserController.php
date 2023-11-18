<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
      $user = User::find($id);
      //$this->authorize('show', $user);
      return view('pages.user', ['user' => $user]);
    }

    /*public function list()
    {
      $users = User::all();
      return view('pages.usersListing', ['users' => $users]);
    }*/
}
