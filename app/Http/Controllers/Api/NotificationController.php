<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();

        return apiResponse(200, "All Notification", $notifications);
    }

    /**
     * عرض الإشعارات غير المقروءة فقط
     */
    public function unread()
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications()->latest()->get();


        return apiResponse(200, "All Unread Notification", $unreadNotifications);

    }

    /**
     * وضع إشعار معين كمقروء
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

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
        $notification = $user->notifications()->where('id', $id)->first();

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
        $user->notifications()->delete();
        return apiResponse(200, "All Notification deleted");


    }


    /**
     * جعل كل الإشعارات غير المقروءة مقروءة
     */
    public function markAllAsRead()
    {
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 200,
            'message' => 'All unread notifications marked as read'
        ]);
    }




}
