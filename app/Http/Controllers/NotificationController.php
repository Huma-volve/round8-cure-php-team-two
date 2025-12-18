<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Doctor;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::guard('doctor')->user();
        $notifications = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->latest()
            ->paginate(5);


        // return view("layouts.dashboard.include.notification")->with(['count' => $notifications->count(),
        // 'data' => NotificationResource::collection($notifications)]);
        return response()->json([
            'count' => $notifications->count(),
            'data' => NotificationResource::collection($notifications),
        ]);

    }

    public function all()
    {
        $user = Auth::guard('doctor')->user();

        $notifications = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->latest()
            ->paginate(10);

        return view("dashboard.doctor-booking.notifications.index", compact('notifications'));
    }

    /**
     * عرض الإشعارات غير المقروءة فقط
     */
    public function unread()
    {
        $user = Auth::user();
        $unreadNotifications = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))->wherenull('read_at')
            ->latest()
            ->paginate(10);


        return response()->json([
            'count' => $unreadNotifications->count(),
            'data' => NotificationResource::collection($unreadNotifications),
        ]);


    }

    /**
     * وضع إشعار معين كمقروء
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->first();

        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found');
        }

        $notification->read_at = now();
        $notification->save();


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
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->first();
        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found');
        }

        $notification->delete();
        $notification->save();

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
        DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->delete();


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
        $notification = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

       
        return redirect()
            ->back()
            ->with('success', 'All unread notifications marked as read');
    }





}
