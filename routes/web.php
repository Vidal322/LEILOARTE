<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home

Route::get('/', 'Auth\LoginController@home');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Auction
Route::get('/', 'AuctionController@index')->name('home');
Route::get('/auctions/create', 'AuctionController@showCreateForm')->name('createAuctionForm');
Route::post('/auctions/create', 'AuctionController@create')->name('createAuction');
Route::get('/auctions/{id}', 'AuctionController@show')->name('auctions');
Route::get('auctions/{id}/edit', 'AuctionController@showEditForm')->name('editAuctionForm');
Route::post('auctions/{id}/edit', 'AuctionController@edit')->name('editAuction');
Route::get('auctions/{id}/delete', 'AuctionController@delete')->name('deleteAuction');

// Users
Route::get('users/{id}', 'UserController@show')->name('user');
Route::get('users/{id}/auctions', 'AuctionController@ownedBy')->name('ownedAuctions');
Route::get('users/{id}/edit', 'UserController@showEditForm')->name('editUserForm');
Route::post('users/{id}/edit', 'UserController@edit')->name('editUser');
Route::post('users/{id}/delete', 'UserController@delete')->name('deleteUser');
Route::post('users/{id}/followAuctions', 'AuctionController@follow')->name('followAuctions');
Route::get('users/{id}/followAuctions', 'AuctionController@followedBy')->name('followedAuctions');
Route::post('users/{id}/unfollowAuctions', 'AuctionController@unfollow')->name('unfollowAuctions');

// Bids
Route::get('auctions/{id}/bid', 'BidController@showCreateForm')->name('createBidForm');
Route::post('auctions/{id}/bid', 'BidController@create')->name('createBid');



// Search
Route::get('api/search/', 'AuctionController@ftsSearch')->name('FTSsearch');
