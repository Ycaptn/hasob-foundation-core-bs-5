<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Models\ModelDocumentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelDocumentCreatedListener
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
     * @param  ModelDocumentCreated  $event
     * @return void
     */
    public function handle(ModelDocumentCreated $event)
    {
        //
    }
}
