<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case PendingPayment = 'pending_payment';
    case Paid           = 'paid';
    case Cancelled      = 'cancelled';
    case Completed      = 'completed';

    case Confirmed = 'confirmed';
}
