<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireOldBookings extends Command
{
    protected $signature = 'bookings:expire';
    protected $description = 'Mark expired bookings as ended';

    public function handle()
    {
        $expiredBookings = Booking::where('status', 0)
            ->where('end_date', '<', Carbon::now())
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->status = 1; // Mark as ended
            $booking->save();
        }

        $this->info('Expired bookings updated successfully.');
    }
}
