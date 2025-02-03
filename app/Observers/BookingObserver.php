<?php

namespace App\Observers;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        Log::info('Sending booking confirmation email to: ' . $booking->customer_email);

        try {
            Mail::to($booking->customer_email)->send(new BookingConfirmationMail($booking));
            Log::info('Email sent successfully to: ' . $booking->customer_email);
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
