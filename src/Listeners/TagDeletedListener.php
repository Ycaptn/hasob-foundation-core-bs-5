<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Tag;
use Hasob\FoundationCore\Models\TagDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TagDeletedListener
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
     * @param  TagDeleted  $event
     * @return void
     */
    public function handle(TagDeleted $event)
    {
        //
    }
}
