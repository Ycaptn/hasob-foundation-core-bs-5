<?php


namespace Hasob\FoundationCore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Hasob\FoundationCore\Models\PaymentDisbursement;

class PaymentDisbursementDeletedNotification extends Notification
{

    use Queueable;


    public $paymentDisbursement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PaymentDisbursement $paymentDisbursement)
    {
        $this->paymentDisbursement = $paymentDisbursement;
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
        return (new MailMessage)->subject('PaymentDisbursement deleted successfully')
                                ->markdown(
                                    'mail.paymentDisbursements.deleted',
                                    ['paymentDisbursement' => $this->paymentDisbursement]
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
