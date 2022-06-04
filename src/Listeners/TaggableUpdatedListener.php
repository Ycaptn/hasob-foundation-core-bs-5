<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Taggable;
use Hasob\FoundationCore\Models\TaggableUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaggableUpdatedListener
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
     * @param  TaggableUpdated  $event
     * @return void
     */
    public function handle(TaggableUpdated $event)
    {
        //
    }
}
