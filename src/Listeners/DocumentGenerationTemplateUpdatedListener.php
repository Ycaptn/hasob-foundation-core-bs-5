<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\DocumentGenerationTemplate;
use Hasob\FoundationCore\Models\DocumentGenerationTemplateUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentGenerationTemplateUpdatedListener
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
     * @param  DocumentGenerationTemplateUpdated  $event
     * @return void
     */
    public function handle(DocumentGenerationTemplateUpdated $event)
    {
        //
    }
}
