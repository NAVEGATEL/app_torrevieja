<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $unsubscribeLink;

    /**
     * Create a new message instance.
     *
     * @param string $unsubscribeLink
     */
    public function __construct($unsubscribeLink)
    {
        $this->unsubscribeLink = $unsubscribeLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscription-confirmation')
                    ->subject('Confirmación de suscripción')
                    ->with([
                        'unsubscribeLink' => $this->unsubscribeLink,
                    ]);
    }
}
