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
use App\Events\NewBid;

class BidController extends Controller
{
    public function create(Request $request, $auction_id)
    {

    try {
        $this->authorize('create', [Bid::class, $auction_id]);

    } catch (AuthorizationException $e) {
        return back()->with('error', 'You are not authorized to perform this action.');
    }

    $user = Auth::user();
    $bid = new Bid();
    $bid->user_id = $user->id;
    $bid->auction_id = $auction_id;
    $bid->amount = $request->input('amount');
    $bid->save();

    event(new NewBid($bid->id, $auction_id));

    return view('pages.auction',['auction' => $auction_id]);
    }

    public function showCreateForm($auction_id)
    {
        // try {
        //     $this->authorize('create', [Bid::class,$auction_id]);

        // } catch (AuthorizationException $e) {
        //     return back()->with('error', 'You are not authorized to perform this action.');
        // }
        return view('pages.createBid', ['id' => $auction_id]);
        }

    public function biddedBy($user_id)
    {
      $bids = Bid::get()->where('user_id', $user_id);
      return view('pages.ownedBids', ['bids' => $bids]);
    }

    public function show($id)
    {
      $bid = Bid::find($id);
      return view('pages.ownedBids', ['bid' => $bid, 'user' => $bid->user_id]);
    }

}
