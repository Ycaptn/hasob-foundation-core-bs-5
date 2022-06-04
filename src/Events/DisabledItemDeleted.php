<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\DisabledItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DisabledItemDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $disabledItem;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DisabledItem $disabledItem)
    {
        $this->disabledItem = $disabledItem;
    }

}
