<?php


namespace Hasob\FoundationCore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Hasob\FoundationCore\Models\LedgerTransfer;

class LedgerTransferDeletedNotification extends Notification
{

    use Queueable;


    public $ledgerTransfer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(LedgerTransfer $ledgerTransfer)
    {
        $this->ledgerTransfer = $ledgerTransfer;
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
        return (new MailMessage)->subject('LedgerTransfer deleted successfully')
                                ->markdown(
                                    'mail.ledgerTransfers.deleted',
                                    ['ledgerTransfer' => $this->ledgerTransfer]
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
