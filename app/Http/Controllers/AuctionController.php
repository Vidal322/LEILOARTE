<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;


class AuctionController extends Controller
{
    
    public function list()
    {
      $auctions = Auction::all();
      return view('pages.auctionsListing', ['auctions' => $auctions]);
    }

}
