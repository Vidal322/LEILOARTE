<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auction;
use App\Models\AuctionSave;
use Illuminate\Auth\Access\AuthorizationException;
use App\Events\NotificationEvent;

class AuctionController extends Controller
{
    public static function returnAuction($id)
    {
      $auction = Auction::find($id);
      return $auction;
    }

    public function list()
    {
      $auctions = Auction::where('active', true)->paginate(10);
      return view('pages.auctionsListing', ['auctions' => $auctions]);
    }

    public function bids($id)
    {
      $auction = Auction::find($id);
      $bids = $auction->bids()->orderBy('amount', 'desc')->get();
      return view('pages.bids', ['bids' => $bids]);
    }

    public function show($id)
    {
      $auction = Auction::with(['bids', 'auctionsSaved'])->find($id);
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
      $this->authorize('create', Auction::class);
      return view('pages.createAuction', ['id' => Auth::user()->id]);
    }

    public function create(Request $request)
    {
      $auction = new Auction();
      $this->authorize('create', $auction);
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

    public function delete($id) {
        $auction = Auction::find($id);
        event(new NotificationEvent($id));
        try {
            $this->authorize('delete', $auction);
        }
        catch (AuthorizationException $e) {
            return back()->with('error', 'You are not authorized to perform this action.');
        }
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
    public function ftsSearch(Request $request) {
        $perPage = 9;

        $query = Auction::query();

        if ($request->has('text') && $request->get('text') != '') {

            $search = $request->get('text');

            $formattedSearch = str_replace(' ', ' | ', $search);
            $query = Auction::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$formattedSearch]);
        }

        $query->where('active', true);

        $query->with('owner');

        $auctions = $query->paginate($perPage);

        $pagination = [
            'current_page' => $auctions->currentPage(),
            'per_page' => $auctions->perPage(),
            'total' => $auctions->total(),
        ];

        $response = [
            'data' => $auctions->items(),
            'pagination' => $pagination,
        ];



        return response()->json($response);
    }

    public function index(Request $request) {
        $auctions = json_decode($this->ftsSearch($request)->content());
        return view('pages.auctionsListing', ['auctions' => $auctions]);
    }
      //$auctions = Auction::where('name', 'LIKE', '%' . $search . '%')->get();
}
