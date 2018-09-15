<?php

namespace PendoNL\LaravelNotificationsChannelPushed\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static($response);
    }

    public static function genericError($message)
    {
        return new static($message);
    }
}