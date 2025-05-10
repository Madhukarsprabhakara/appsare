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
use App\Notifications\Channels\PushoverChannel;
use App\Notifications\Messages\PushoverMessage;
use App\Services\SlackService;
use App\Services\PushoverService;
use App\Services\NotificationSettingsService;
use App\Models\Team;
use App\Models\User;
use App\Notifications\Channels\BasecampCampfireChannel;
use App\Services\BasecampService;
class ServiceUp extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $url, $team_id, $user_id;
    public function __construct($url, $team_id, $user_id)
    {
        //
        $this->url=$url;
        $this->team_id=$team_id;
        $this->user_id=$user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','slack', PushoverChannel::class, BasecampCampfireChannel::class];
    }
    public function shouldSend(object $notifiable, string $channel): bool
    {
        $team=Team::find($this->team_id);
        $user=User::find($this->user_id);
        $notificationSettingsService = new NotificationSettingsService();
        $notificationSettings = $notificationSettingsService->getGlobalNotificationSettingsOnTeam($team);
        if (!$notificationSettings[0]->notificatons_enabled)
        {
            return false;
        }
        if ($channel === 'mail') {
            return $notificationSettingsService->shouldSendEmail($user, $team);
        }
        if ($channel === 'slack') {
            $slackService=new SlackService();
            $slack_connect=$slackService->getSlackConnection($this->team_id);
            if ($slack_connect)
            {
                if ($slack_connect->slack_channel_id)
                {
                    return $notificationSettingsService->shouldSendSlack($user, $team);
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
                return $notificationSettingsService->shouldSendPushover($user, $team);
            }
            return false;
        }
        if ($channel === BasecampCampfireChannel::class) {
            $basecampService = new BasecampService();
            $basecamp_connect = $basecampService->getBasecampConnection($this->team_id);
            if ($basecamp_connect) {
                if ($basecamp_connect->access_token && $basecamp_connect->campfire_line) {
                    return $notificationSettingsService->shouldSendBasecamp($user, $team);
                }
                return false;
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
                    ->subject('Up')
                    ->line('Your website '.$this->url.' is up again.')
                    ->line('You can rest easy now!');
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
                ->headerBlock('Up again')
                ->contextBlock(function (ContextBlock $block) {
                    $block->text('Your website '.$this->url.' is up again.');
                });
            }
        }
                 
    }
    public function toPushover(object $notifiable): PushoverMessage
    {
        return (new PushoverMessage('Your website '.$this->url.' is up again.'))
            ->title('Up')
            ->priority(0);
        
    }
    public function toBasecampCampfire(object $notifiable): array
    {

        return [
            'content' => 'Your website '.$this->url.' is up again.',
        ];
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
            'team_id' => $this->team_id,
        ];
    }
}
