<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(10);

        return NotificationResource::collection($notifications);
    }

    /**
     * عرض الإشعارات غير المقروءة فقط
     */
    public function unread()
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications()->latest()->paginate(10);


        return NotificationResource::collection($unreadNotifications);

    }

    /**
     * وضع إشعار معين كمقروء
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found');
        }

        $notification->markAsRead();
        return redirect()
            ->back()
            ->with('success', 'Notification marked as read');


    }

    /**
     * مسح إشعار معين
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found');
        }

        $notification->delete();

        return redirect()
            ->back()
            ->with('success', 'Notification deleted');
    }

    /**
     * مسح كل الإشعارات
     */
    public function destroyAll()
    {
        $user = Auth::user();
        $user->notifications()->delete();
        return redirect()
            ->back()
            ->with('success', 'All notifications deleted');


    }


    /**
     * جعل كل الإشعارات غير المقروءة مقروءة
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return redirect()
            ->back()
            ->with('success', 'All unread notifications marked as read');
    }
    




}
