<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\ModelArtifact;
use Hasob\FoundationCore\Models\ModelArtifactDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelArtifactDeletedListener
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
     * @param  ModelArtifactDeleted  $event
     * @return void
     */
    public function handle(ModelArtifactDeleted $event)
    {
        //
    }
}
