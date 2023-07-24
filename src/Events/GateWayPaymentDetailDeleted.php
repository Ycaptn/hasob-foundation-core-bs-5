<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\GateWayPaymentDetail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GateWayPaymentDetailDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gateWayPaymentDetail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(GateWayPaymentDetail $gateWayPaymentDetail)
    {
        $this->gateWayPaymentDetail = $gateWayPaymentDetail;
    }

}
