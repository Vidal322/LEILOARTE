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
      $auctions = Auction::paginate(10);
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

    public function unfollow($auction_id)
    {
      $auctionSave = AuctionSave::where('user_id', Auth::user()->id)->where('auction_id', $auction_id)->delete();
      return redirect('auctions/'.$auction_id);
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
      $this->authorize('delete', $auction);
      $auction->delete();
      return redirect('/');
    }

    public function listBids($id)
    {
      $auction = Auction::find($id);
      $bids = $auction->bids()->orderBy('amount', 'desc')->get();
      return view('pages.bids', ['bids' => $bids]);
    }

    
    // search using tsvectors
    public function ftsSearch(Request $request)
    { 
      if ($request->has('text') && $request->get('text') != '') {

      $search = $request->get('text');

      $formattedSearch = str_replace(' ', ' | ', $search);
      $auctions = Auction::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedSearch])->get();

      }

      else {
        $auctions = Auction::all();
      }

      return response()->json($auctions);
      //return view('pages.auctionsListing', ['auctions' => $auctions]);

    }

    public function index(Request $request) {
      $auctions = json_decode($this->ftsSearch($request)->content());
      return view('pages.auctionsListing', ['auctions' => $auctions]);
    }
      //$auctions = Auction::where('name', 'LIKE', '%' . $search . '%')->get();
      //return response()->json($auctions);
}
