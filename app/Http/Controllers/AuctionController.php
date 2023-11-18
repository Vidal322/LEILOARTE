<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auction;
use App\Models\AuctionSave;

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

    public function followedBy($user_id)
    {
      $allAuctions = Auction::all();
      $auctions = [];
      foreach ($allAuctions as $auction) {
        if (AuctionSave::where('user_id', $user_id)->where('auction_id', $auction->id)->exists()) {
          array_push($auctions, $auction);
        }
      }
      return view('pages.followedAuctions', ['auctions' => $auctions]);
    }

    public function follow($id)
    {
      $auctionSave = new AuctionSave;
      $auctionSave->user_id = Auth::user()->id;
      $auctionSave->auction_id = $id;
      $auctionSave->save();
      return redirect('auctions/'.$id);
    }

    public function showCreateForm()
    {
      return view('pages.createAuction', ['id' => Auth::user()->id]);
    }

    public function create(Request $request)
    {
      $auction = new Auction();

      $auction->name = $request->input('name');
      $auction->description = $request->input('description');
      $auction->image = $request->input('image');
      $auction->owner_id = Auth::user()->id;
      // $auction->start_date = $request->input('start_date');
      $auction->end_t = $request->input('end_t');
      $auction->save();

      return redirect('auctions/' . $auction->id);
    }

    public function showEditForm($id)
    {
      //$id = Auction::find($id);
      return view('pages.editAuction', ['id' => $id]);
    }
    public function edit(Request $request, $id)
    {
      $auction = Auction::find($id);
      $auction->name = $request->input('name');
      $auction->description = $request->input('description');
      $auction->image = $request->input('image');
      $auction->owner_id = Auth::user()->id;
      // $auction->start_date = $request->input('start_date');
      $auction->end_t = $request->input('end_t');
      $auction->save();

      return redirect('auctions/' . $auction->id);
    }

    public function delete($id)
    {
      $auction = Auction::find($id);
      $auction->delete();
      return redirect('/');
    }
}
