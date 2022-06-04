<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Tag;
use Hasob\FoundationCore\Models\TagCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TagCreatedListener
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
     * @param  TagCreated  $event
     * @return void
     */
    public function handle(TagCreated $event)
    {
        //
    }
}
