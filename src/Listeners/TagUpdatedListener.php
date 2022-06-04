<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Tag;
use Hasob\FoundationCore\Models\TagUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TagUpdatedListener
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
     * @param  TagUpdated  $event
     * @return void
     */
    public function handle(TagUpdated $event)
    {
        //
    }
}
