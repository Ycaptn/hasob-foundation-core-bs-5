<?php


namespace Hasob\FoundationCore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Hasob\FoundationCore\Models\FiscalYearPeriod;

class FiscalYearPeriodCreatedNotification extends Notification
{

    use Queueable;


    public $fiscalYearPeriod;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FiscalYearPeriod $fiscalYearPeriod)
    {
        $this->fiscalYearPeriod = $fiscalYearPeriod;
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
        return (new MailMessage)->subject('FiscalYearPeriod created successfully')
                                ->markdown(
                                    'mail.fiscalYearPeriods.created',
                                    ['fiscalYearPeriod' => $this->fiscalYearPeriod]
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
