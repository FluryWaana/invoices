<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case SENT = 'sent';
    case LATE = 'late';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
}
