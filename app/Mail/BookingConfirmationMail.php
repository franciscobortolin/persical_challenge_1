<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmation Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_confirmation',
            with: [
                'customerName' => $this->booking->customer_name,
                'tourName' => $this->booking->tour->name ?? 'N/A',
                'hotelName' => $this->booking->hotel->name ?? 'N/A',
                'bookingDate' => $this->booking->booking_date,
                'numberOfPeople' => $this->booking->number_of_people,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
