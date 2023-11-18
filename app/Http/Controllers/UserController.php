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

    public function showEditForm($id)
    {
      //$user = User::find($id);
      //$this->authorize('edit', $user);
      return view('pages.editUser', ['id' => $id]);
    }

    public function edit(Request $request, $id)
    {
      $user = User::find($id);
      //$this->authorize('edit', $user);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->username = $request->input('username');
      $user->update();
      return redirect('users/'.$id);
    }
}
