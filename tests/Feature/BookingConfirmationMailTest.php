<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingConfirmationMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_sends_booking_confirmation_email()
    {
        Mail::fake();

        $booking = Booking::factory()->create([
            'customer_email' => 'test@example.com',
        ]);

        Mail::to($booking->customer_email)->send(new BookingConfirmationMail($booking));

        Mail::assertSent(BookingConfirmationMail::class, function ($mail) use ($booking) {
            return $mail->booking->id === $booking->id &&
                   $mail->hasTo($booking->customer_email);
        });
    }
}
