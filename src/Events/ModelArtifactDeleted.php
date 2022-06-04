<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\ModelArtifact;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelArtifactDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $modelArtifact;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ModelArtifact $modelArtifact)
    {
        $this->modelArtifact = $modelArtifact;
    }

}
