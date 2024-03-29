<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\ModelDocument;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelDocumentDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $modelDocument;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ModelDocument $modelDocument)
    {
        $this->modelDocument = $modelDocument;
    }

}
