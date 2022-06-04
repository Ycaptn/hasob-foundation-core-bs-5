<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\FiscalYearPeriod;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FiscalYearPeriodCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fiscalYearPeriod;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FiscalYearPeriod $fiscalYearPeriod)
    {
        $this->fiscalYearPeriod = $fiscalYearPeriod;
    }

}
