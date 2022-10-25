<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\DocumentGenerationTemplate;
use Hasob\FoundationCore\Models\DocumentGenerationTemplateDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentGenerationTemplateDeletedListener
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
     * @param  DocumentGenerationTemplateDeleted  $event
     * @return void
     */
    public function handle(DocumentGenerationTemplateDeleted $event)
    {
        //
    }
}
