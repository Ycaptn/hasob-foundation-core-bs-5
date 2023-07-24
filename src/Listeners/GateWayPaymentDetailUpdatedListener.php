<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\GateWayPaymentDetail;
use Hasob\FoundationCore\Models\GateWayPaymentDetailUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GateWayPaymentDetailUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GateWayPaymentDetailUpdated  $event
     * @return void
     */
    public function handle(GateWayPaymentDetailUpdated $event)
    {
        //
    }
}
