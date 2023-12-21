<?php

use App\Models\User;

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

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->middleware('checkBlocked');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('forgotPassword', 'Auth\ForgotPasswordController@show')->name('forgotPassword');

Route::get('/resetPassword/{token}', function ($token) {
    $tokenExists = User::where('token', $token)->first();

    if (!$tokenExists) {
        return redirect(route('home'))->with('error', 'Invalid token.');
    }
    return view('auth.resetPassword', ['token' => $token]);
})->middleware('guest')->name('resetPassword');

// Auction
Route::get('/', 'AuctionController@index')->name('home');
Route::get('/auctions/create', 'AuctionController@showCreateForm')->name('createAuctionForm');
Route::post('/auctions/create', 'AuctionController@create')->name('createAuction');
Route::get('/auctions/{id}', 'AuctionController@show')->name('auctions');
Route::get('auctions/{id}/edit', 'AuctionController@showEditForm')->name('editAuctionForm');
Route::post('auctions/{id}/edit', 'AuctionController@edit')->name('editAuction');
Route::get('auctions/{id}/delete', 'AuctionController@delete')->name('deleteAuction');

// Users
Route::get('users/blocked', 'UserController@listBlockedUsers')->name('blockedUsers');
Route::post('users/{id}/block', 'UserController@block')->name('blockUser');
Route::post('users/{id}/unblock', 'UserController@unblock')->name('unblockUser');
Route::get('users/{id}', 'UserController@show')->name('user');
Route::get('users/{id}/auctions', 'AuctionController@ownedBy')->name('ownedAuctions');
Route::get('users/{id}/edit', 'UserController@showEditForm')->name('editUserForm');
Route::post('users/{id}/edit', 'UserController@edit')->name('editUser');
Route::post('users/{id}/delete', 'UserController@delete')->name('deleteUser');
Route::post('users/{id}/followAuctions', 'AuctionController@follow')->name('followAuctions');
Route::get('users/{id}/followAuctions', 'AuctionController@followedBy')->name('followedAuctions');
Route::post('users/{id}/unfollowAuctions', 'AuctionController@unfollow')->name('unfollowAuctions');
Route::post('resetPassword', 'UserController@resetPassword')->name('resetPassword');
Route::post('users/{id}/rate', 'UserController@rate')->name('rateUser');

// Bids
Route::get('auctions/{id}/bid', 'BidController@showCreateForm')->name('createBidForm');
Route::post('auctions/{id}/bid', 'BidController@create')->name('createBid');
Route::get('/users/{id}/bids', 'BidController@biddedBy')->name('userBids');

// Notifications
Route::get('users/{id}/notifications', 'NotificationController@index')->name('notificationsCenter');
Route::post('notifications/{id}/seen', 'NotificationController@seen')->name('seenNotification'); // TODO
Route::post('notifications/{id}/delete', 'NotificationController@delete')->name('deleteNotification'); // TODO


// Files
Route::post('/file/upload', 'FileController@upload')->name('uploadFile');

//Email
Route::post('/send', 'MailController@send')->name('sendEmail');

// About Us
Route::get('aboutus', 'AboutUsController@show')->name('aboutUs');

// Search
Route::get('api/search/', 'AuctionController@ftsSearch')->name('FTSsearch');

// FAQs
Route::get('faqs', 'FAQController@list')->name('faqs');
Route::get('faqs/{id}/edit', 'FAQController@showEditForm')->name('editFAQForm');
Route::post('faqs/{id}/edit', 'FAQController@edit')->name('editFAQ');
Route::post('faqs/{id}/delete', 'FAQController@delete')->name('deleteFAQ');
Route::post('/faqs/create', 'FAQController@create')->name('createFAQ');
