<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\ModelArtifact;
use Hasob\FoundationCore\Models\ModelArtifactCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelArtifactCreatedListener
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
     * @param  ModelArtifactCreated  $event
     * @return void
     */
    public function handle(ModelArtifactCreated $event)
    {
        //
    }
}
