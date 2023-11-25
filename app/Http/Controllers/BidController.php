<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use League\CommonMark\Node\Query;

class BidController extends Controller
{
    public function create(Request $request, $id)
    {
      $user = Auth::user();
      //Log::info("User {$user->id} type: {$user->type} username: {$user->username}");
      $bid = new Bid;
      $bid->user_id = $user->id;
      $bid->auction_id = $id;
      $bid->amount = $request->input('amount');

      //find top bid
      $auction = Auction::find($id);
        $bids = $auction->bids()->orderBy('amount', 'desc')->get();
        if (count($bids) != 0) {
          $topBid = $bids[0];
        }
        else {
          $topBid = null;
        }
      try {
        $this->authorize('bid', [$user, $topBid]);
        $bid->save();
    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }
      catch (QueryException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
      }
      return redirect('auctions/'.$id);
    }

    public function showCreateForm($auction_id)
    {
      $this->authorize('create', Bid::class);
      return view('pages.createBid', ['id' => $auction_id]);
    }



}
