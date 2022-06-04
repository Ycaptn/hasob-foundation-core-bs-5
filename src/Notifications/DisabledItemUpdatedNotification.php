<?php

namespace Hasob\FoundationCore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Hasob\FoundationCore\Models\DisabledItem;

class DisabledItemUpdatedNotification extends Notification
{

    use Queueable;


    public $disabledItem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DisabledItem $disabledItem)
    {
        $this->disabledItem = $disabledItem;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('DisabledItem updated successfully')
                                ->markdown(
                                    'mail.disabledItems.updated',
                                    ['disabledItem' => $this->disabledItem]
                                );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }

}
