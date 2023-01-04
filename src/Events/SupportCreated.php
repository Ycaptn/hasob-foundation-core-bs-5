<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\Support;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $support;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Support $support)
    {
        $this->support = $support;
    }

}
