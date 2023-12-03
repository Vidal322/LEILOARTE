<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller {

    public function index($id){
        $notifications = Notification::where('user_id', $id)->orderBy('date', 'desc')->get();

        return view('pages.notificationsCenter', ['notifications' => $notifications]);
    }

    public function delete($id){
        $notification = Notification::find($id);
        $notification->delete();

        return redirect(route('notificationsCenter', ['id' => $notification->user_id]));
    }
}
