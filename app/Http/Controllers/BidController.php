<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\User;
use App\Models\Auction;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
      } else {
        $topBid = null;
      }
      Log::info("user: {$user}");
      Log::info("Top bid: {$topBid}");
      //policy
      $this->authorize('bid', [$user, $topBid]);

      $bid->save();
      return redirect('auctions/'.$id);
    }

    public function showCreateForm($auction_id)
    {
      return view('pages.createBid', ['id' => $auction_id]);
    }

    

}
