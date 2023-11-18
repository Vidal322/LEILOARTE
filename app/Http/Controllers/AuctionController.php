<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;


class AuctionController extends Controller
{
    
    public function list()
    {
      $auctions = Auction::all();
      return view('pages.auctionsListing', ['auctions' => $auctions]);
    }

    public function show($id)
    {
      $auction = Auction::find($id);
      return view('pages.auction', ['auction' => $auction]);
    }

    public function ownedBy($user_id)
    {
      $auctions = Auction::get()->where('owner_id', $user_id);
      return view('pages.ownedAuctions', ['auctions' => $auctions]);
    }


}
