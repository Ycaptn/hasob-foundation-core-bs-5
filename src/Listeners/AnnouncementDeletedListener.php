<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Announcement;
use Hasob\FoundationCore\Models\AnnouncementDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AnnouncementDeletedListener
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
     * @param  AnnouncementDeleted  $event
     * @return void
     */
    public function handle(AnnouncementDeleted $event)
    {
        //
    }
}
