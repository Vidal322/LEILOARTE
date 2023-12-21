<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function show($id)
    {
      $user = User::find($id);
    //   try {
    //$this->authorize('view', $user);
    // } catch (AuthorizationException $e) {
    //     return back()->with('error', 'You are not authorized to perform this action.');
    // }

      return view('pages.user', ['user' => $user]);
    }

    public static function returnUser($id)
    {
      $user = User::find($id);
      return $user;
    }

    public function list()
    {
      $users = User::all();
      return view('pages.usersListing', ['users' => $users]);
    }

    public function showEditForm($id)
    {
      $user = User::find($id);
      try {
        $this->authorize('edit', $user);
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }

      return view('pages.editUser', ['id' => $id]);
    }

    public function edit(Request $request, $id)
    {
      $user = User::find($id);
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->username = $request->input('username');
      try {
        $this->authorize('edit', $user);
        $user->update();
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }
      catch (QueryException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
      }

      return redirect('users/'.$id);
    }

    public function delete($id)
    {
      $user = User::find($id);
      $user->deleted = true;
      try {
        $this->authorize('deleteUser', $user);;
        $user->update();
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }
      catch (QueryException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
      }
      Auth::logout();

      return redirect(route('home'));
    }

    // do rate function that takes the user id and the rating and adds rating to the mean
    public function rate(Request $request, $id)
    {
      $user = User::find($id);
      $user->rate = ($user->rate * $user->rate_count + $request->input('rate')) / ($user->rate_count + 1);
      $user->rate_count = $user->rate_count + 1;
      $user->save();
      return redirect('users/'.$id);
    }

}
