<?php


namespace Hasob\FoundationCore\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Hasob\FoundationCore\Models\DocumentGenerationTemplate;

class DocumentGenerationTemplateCreatedNotification extends Notification
{

    use Queueable;


    public $documentGenerationTemplate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DocumentGenerationTemplate $documentGenerationTemplate)
    {
        $this->documentGenerationTemplate = $documentGenerationTemplate;
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
        return (new MailMessage)->subject('DocumentGenerationTemplate created successfully')
                                ->markdown(
                                    'mail.documentGenerationTemplates.created',
                                    ['documentGenerationTemplate' => $this->documentGenerationTemplate]
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
