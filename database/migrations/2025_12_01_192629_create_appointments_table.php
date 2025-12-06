<?php

use App\Enums\AppointmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('price');
            $table->enum('status', [
                AppointmentStatus::PendingPayment->value,
                AppointmentStatus::Paid->value,
                AppointmentStatus::Cancelled->value,
                AppointmentStatus::Completed->value,
            ])->default(AppointmentStatus::PendingPayment->value);
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
