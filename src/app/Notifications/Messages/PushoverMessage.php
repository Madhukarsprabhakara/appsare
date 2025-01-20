<?php
namespace App\Notifications\Messages;

class PushoverMessage
{
    public $content;
    public $title;
    public $url;
    public $url_title;
    public $priority;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function url($url, $url_title = null)
    {
        $this->url = $url;
        $this->url_title = $url_title;
        return $this;
    }

    public function priority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
}