<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Models\ModelDocumentUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelDocumentUpdatedListener
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
     * @param  ModelDocumentUpdated  $event
     * @return void
     */
    public function handle(ModelDocumentUpdated $event)
    {
        //
    }
}
