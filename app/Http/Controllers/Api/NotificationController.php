<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Doctor;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;


class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::guard('sanctum')->user();


        $notifications = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->latest()
            ->paginate(10);


        return apiResponse(200, "All Notification", NotificationResource::collection($notifications));
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


        return apiResponse(200, "All Unread Notification", NotificationResource::collection($unreadNotifications));

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
            return response()->json(['status' => 404, 'message' => 'Notification not found']);
        }

        $notification->markAsRead();

        return apiResponse(200, "Notification marked as read");


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
            return response()->json(['status' => 404, 'message' => 'Notification not found']);
        }

        $notification->delete();

        return apiResponse(200, "Notification deleted");
    }

    /**
     * مسح كل الإشعارات
     */
    public function destroyAll()
    {
        $user = Auth::user();
        $notification = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->delete();

    
        return apiResponse(200, "All Notification deleted");


    }


    /**
     * جعل كل الإشعارات غير المقروءة مقروءة
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
      DatabaseNotification::where('notifiable_id', Auth::id())
    ->where('notifiable_type', get_class(Auth::user()))
    ->whereNull('read_at')
    ->update(['read_at' => now()]);
      
        return response()->json([
            'status' => 200,
            'message' => 'All unread notifications marked as read'
        ]);
    }




}