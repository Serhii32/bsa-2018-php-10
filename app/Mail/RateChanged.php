<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Entity\Currency;
use App\User;

class RateChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $currency;
    public $oldRate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Currency $currency, float $oldRate)
    {
        $this->user = $user;
        $this->currency = $currency;
        $this->oldRate = $oldRate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email', [
            'userName' => $this->user->name,
            'currencyName' => $this->currency->name,
            'oldRate' => $this->oldRate,
            'newRate' => $this->currency->rate,
        ]);
    }
}
