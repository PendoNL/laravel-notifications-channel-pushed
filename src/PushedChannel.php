<?php

namespace PendoNL\LaravelNotificationsChannelPushed;

use Illuminate\Notifications\Notification;

class PushedChannel
{
    protected $pushed;

    public function __construct(Pushed $pushed)
    {
        $this->pushed = $pushed;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toPushed($notifiable);

        $this->pushed->send($message->payload());
    }
}
