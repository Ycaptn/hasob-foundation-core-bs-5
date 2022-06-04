<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Taggable;
use Hasob\FoundationCore\Models\TaggableCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaggableCreatedListener
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
     * @param  TaggableCreated  $event
     * @return void
     */
    public function handle(TaggableCreated $event)
    {
        //
    }
}
