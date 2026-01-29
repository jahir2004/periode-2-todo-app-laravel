<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display alle notificaties voor de huidige gebruiker
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Markeer een notificatie als gelezen
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notificatie gemarkeerd als gelezen');
    }

    /**
     * Markeer alle notificaties als gelezen
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return redirect()->back()->with('success', 'Alle notificaties gemarkeerd als gelezen');
    }

    /**
     * Toon alleen ongelezen notificaties
     */
    public function unread()
    {
        $notifications = auth()->user()->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }
}
