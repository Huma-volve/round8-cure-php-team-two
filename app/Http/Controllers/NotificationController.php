<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Doctor;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();
        $notifications = Notification::where(["notifiable_type" => "App\Models\Doctor", "notifiable_id" => $doctor->id])
            ->latest()->get();


        return response()->json([
            'count' => $notifications->count(),
            'data' => NotificationResource::collection($notifications),
        ]);

    }

    /**
     * عرض الإشعارات غير المقروءة فقط
     */
    public function unread()
    {
        $doctor = Auth::user();
        $unreadNotifications = Notification::where(["notifiable_type" => "App\Models\Doctor", "notifiable_id" => $doctor->id,
        "read_at"=>null])
            ->latest()->get();


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
        $notification = Notification::where('id', $id)->first();

        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found');
        }

        $notification->read_at=now();
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
        $doctor = Auth::user();
        $notification = Notification::where('id', $id)->first();
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
        $doctor = Auth::user();
        $notification=Notification::where(["notifiable_type" => "App\Models\Doctor", "notifiable_id" => $doctor->id])
            ->latest()->get();
        $notification->delete();
        return redirect()
            ->back()
            ->with('success', 'All notifications deleted');


    }


    /**
     * جعل كل الإشعارات غير المقروءة مقروءة
     */
    public function markAllAsRead()
    {
        $doctor = Auth::user();

        $Notifications = Notification::where(["notifiable_type" => "App\Models\Doctor", "notifiable_id" => $doctor->id,
        "read_at"=>null])->latest()->get();

        $Notifications->read_at=now();

        return redirect()
            ->back()
            ->with('success', 'All unread notifications marked as read');
    }





}
