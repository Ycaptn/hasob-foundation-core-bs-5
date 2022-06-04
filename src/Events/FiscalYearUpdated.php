<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\FiscalYear;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FiscalYearUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fiscalYear;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FiscalYear $fiscalYear)
    {
        $this->fiscalYear = $fiscalYear;
    }

}
