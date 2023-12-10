<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

class BlockController extends Controller
{

    public static function returnBlock($id)
    {
      $block = Block::find($id);
      return $block;
    }

    public function listBlockedUsers($user_id)
    {
        $blockedUsers = User::whereHas('blockedBy', function ($query) use ($user_id) {
            $query->where('blocker_id', $user_id);
        })->get();

        return view('pages.blockedListing', ['blockedUsers' => $blockedUsers]);
    }

    public function blockUser(Request $request, $blocked_id)
    {
        $blocker_id = $request->user()->id;
        $block = new Block();
        $block->blocker_id = $blocker_id;
        $block->blocked_id = $blocked_id;
        try {
            $block->save();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'User already blocked']);
        }
        return view('pages.user', ['user' => User::find($blocker_id)]);
    }

    public function unblockUser(Request $request, $blocked_id)
    {
        $blocker_id = $request->user()->id;
        
        $block = Block::where('blocker_id', $blocker_id)
        ->where('blocked_id', $blocked_id)
        ->first();
        try {
            $block->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'User already unblocked']);
        }
        return redirect()->back();
    }
}