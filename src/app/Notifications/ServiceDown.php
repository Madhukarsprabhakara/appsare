<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\BlockKit\Composites\ConfirmObject;
use App\Services\SlackService;
class ServiceDown extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $url;
    public function __construct($url)
    {
        //
        $this->url=$url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','slack'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Down')
                    ->line('Your website '.$this->url.' is down.')
                    ->line('Please acknowledge receipt of this message by clicking on the link below')
                    ->action('Acknowledge', url('/'));
    }
    public function toSlack(object $notifiable): SlackMessage
    {
        $slackService=new SlackService();
        $slack_connect=$slackService->getSlackDetails($notifiable->currentTeam->id);
        if ($slack_connect)
        {
            if ($slack_connect->slack_channel_id)
            {
                return (new SlackMessage)
                ->headerBlock('Down')
                ->contextBlock(function (ContextBlock $block) {
                    $block->text('Your website '.$this->url.' is down.');
                });
            }
        }
               
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
