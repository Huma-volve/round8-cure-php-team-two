<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;

class Appointment extends Model
{
    protected $fillable = [
        'comment',
        'rating',
        'doctor_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'payment_id',
        'status',
        'price'
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
    ];

    public function review() { return $this->hasOne(Review::class); }
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function patient() { return $this->belongsTo(User::class, 'user_id'); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function user() { return $this->belongsTo(User::class, 'user_id'); }

    // التحقق من إمكانية الإلغاء أو إعادة الجدولة
    public function canCancelOrReschedule(): bool
    {
        // دمج التاريخ والوقت بشكل مضبوط (HH:MM فقط)
        $appointmentDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $this->appointment_date . ' ' . substr($this->appointment_time, 0, 5)
        );

        // ضبط الـ timezone للتأكد من المقارنة الصحيحة
        $appointmentDateTime->setTimezone(config('app.timezone'));

        return Carbon::now()->setTimezone(config('app.timezone'))->lt($appointmentDateTime);
    }
}
