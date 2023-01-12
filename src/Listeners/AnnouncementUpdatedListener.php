<?php

namespace Hasob\FoundationCore\Listeners;

use Hasob\FoundationCore\Models\Announcement;
use Hasob\FoundationCore\Models\AnnouncementUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AnnouncementUpdatedListener
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
     * @param  AnnouncementUpdated  $event
     * @return void
     */
    public function handle(AnnouncementUpdated $event)
    {
        //
    }
}
