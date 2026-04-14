<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $cartItems;
    public $totalPrice;
    public $paymentMethod;
    public $userName;
    public $userEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($cartItems, $totalPrice, $paymentMethod, $userName, $userEmail)
    {
        $this->cartItems = $cartItems;
        $this->totalPrice = $totalPrice;
        $this->paymentMethod = $paymentMethod;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác nhận đặt hàng - Cửa hàng bán Laptop',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'cartItems' => $this->cartItems,
                'totalPrice' => $this->totalPrice,
                'paymentMethod' => $this->paymentMethod,
                'userName' => $this->userName,
                'userEmail' => $this->userEmail,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
