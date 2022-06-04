<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\ModelArtifact;
use Hasob\FoundationCore\Models\ModelArtifactUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelArtifactUpdatedListener
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
     * @param  ModelArtifactUpdated  $event
     * @return void
     */
    public function handle(ModelArtifactUpdated $event)
    {
        //
    }
}
