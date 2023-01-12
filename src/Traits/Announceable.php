<?php
namespace Hasob\FoundationCore\Traits;

use Hasob\FoundationCore\Models\Announcement;

trait Announceable
{

    public function get_announcements()
    {

        return Announcement::where('announceable_id', $this->id)
            ->where('announceable_type', self::class)
            ->orderBy('created_at')
            ->get();
    }

    public function create_announcement(array $data)
    {

        $announcement = Announcement::create($data);
        $announcement->announceable_id = $this->id;
        $announcement->announceable_type = self::class;
        $announcement->save();

        return $announcement;
    }

    public function delete_announcements()
    {

        Announcement::where('announceable_type', self::class)->where('announceable_id', $this->id)->delete();

        return null;
    }

}
