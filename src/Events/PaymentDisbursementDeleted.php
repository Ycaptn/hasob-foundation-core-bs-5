<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\PaymentDisbursement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentDisbursementDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $paymentDisbursement;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PaymentDisbursement $paymentDisbursement)
    {
        $this->paymentDisbursement = $paymentDisbursement;
    }

}
