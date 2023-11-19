<?php

namespace App\Http\Controllers;
use App\Models\AuctionSave;
use Illuminate\Http\Request;

class AuctionSaveController extends Controller
{
    public static function exists($user_id, $auction_id) {
        return AuctionSave::where('user_id', $user_id)->where('auction_id', $auction_id)->exists();
    }
}
