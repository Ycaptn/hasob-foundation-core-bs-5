<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Taggable;
use Hasob\FoundationCore\Models\TaggableDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaggableDeletedListener
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
     * @param  TaggableDeleted  $event
     * @return void
     */
    public function handle(TaggableDeleted $event)
    {
        //
    }
}
