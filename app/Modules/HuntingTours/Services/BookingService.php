<?php

namespace App\Modules\HuntingTours\Services;

use App\Modules\HuntingTours\Models\HuntingBooking;

class BookingService
{
    public function createBooking(array $data): HuntingBooking
    {
        return HuntingBooking::create($data);
    }
}
