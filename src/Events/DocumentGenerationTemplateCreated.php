<?php

namespace Hasob\FoundationCore\Events;

use Hasob\FoundationCore\Models\DocumentGenerationTemplate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentGenerationTemplateCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $documentGenerationTemplate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DocumentGenerationTemplate $documentGenerationTemplate)
    {
        $this->documentGenerationTemplate = $documentGenerationTemplate;
    }

}
