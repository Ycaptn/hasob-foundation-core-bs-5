<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\Taggable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaggableDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taggable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Taggable $taggable)
    {
        $this->taggable = $taggable;
    }

}
