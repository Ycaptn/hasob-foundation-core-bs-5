<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Models\ModelDocumentDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelDocumentDeletedListener
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
     * @param  ModelDocumentDeleted  $event
     * @return void
     */
    public function handle(ModelDocumentDeleted $event)
    {
        //
    }
}
