<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return back();
    }
}
