<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\PushoverChannel;
use App\Notifications\Messages\PushoverMessage;
use Illuminate\Notifications\Slack\SlackMessage;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\BlockKit\Composites\ConfirmObject;
use App\Services\SlackService;
use App\Services\PushoverService;
use App\Services\NotificationSettingsService;
use App\Models\Team;
class ServiceDown extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $url, $team_id;
    public function __construct($url, $team_id)
    {
        //
        $this->url=$url;
        $this->team_id=$team_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','slack', PushoverChannel::class];
    }

    public function shouldSend(object $notifiable, string $channel): bool
    {
        $notificationSettingsService = new NotificationSettingsService();
        $notificationSettings = $notificationSettingsService->getNotificationSettingsOnTeam(Team::find($this->team_id));
        if (!$notificationSettings[0]->notificatons_enabled)
        {
            return false;
        }
        if ($channel === 'slack') {
            $slackService=new SlackService();
            $slack_connect=$slackService->getSlackConnection($this->team_id);
            if ($slack_connect)
            {
                if ($slack_connect->slack_channel_id)
                {
                    return true;
                }
                return false;
            }
            return false;
        }

        if ($channel === PushoverChannel::class) {
            $pushoverService = new PushoverService();
            $pushover_connect=$pushoverService->getPushoverConnection($notifiable->id);
            if ($pushover_connect)
            {
                return true;
            }
            return false;
        }

        return true;
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
        $slack_connect=$slackService->getSlackConnection($this->team_id);
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
     * Get the Pushover representation of the notification.
     */
    public function toPushover(object $notifiable): PushoverMessage
    {
        return (new PushoverMessage('Your website '.$this->url.' is down.'))
            ->title('Down')
            ->priority(1);
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
            'team_id'=>$this->team_id,
        ];
    }
}
