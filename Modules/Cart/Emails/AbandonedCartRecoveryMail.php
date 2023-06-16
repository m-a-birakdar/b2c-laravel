<?php

namespace Modules\Cart\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AbandonedCartRecoveryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct( public array $products ){}

    public string $title = 'Verify your cart';

    public function build(): AbandonedCartRecoveryMail
    {
        return $this->view('cart::emails.abandoned-cart')
            ->subject($this->title)
            ->with([
                'products' => $this->products,
                'title' => $this->title,
            ]);
    }
}
