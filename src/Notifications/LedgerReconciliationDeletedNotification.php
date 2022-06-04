<?php


namespace Hasob\FoundationCore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Hasob\FoundationCore\Models\LedgerReconciliation;

class LedgerReconciliationDeletedNotification extends Notification
{

    use Queueable;


    public $ledgerReconciliation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LedgerReconciliation $ledgerReconciliation)
    {
        $this->ledgerReconciliation = $ledgerReconciliation;
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
        return (new MailMessage)->subject('LedgerReconciliation deleted successfully')
                                ->markdown(
                                    'mail.ledgerReconciliations.deleted',
                                    ['ledgerReconciliation' => $this->ledgerReconciliation]
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
