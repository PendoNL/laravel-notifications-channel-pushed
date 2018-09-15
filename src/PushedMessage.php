<?php

namespace PendoNL\LaravelNotificationsChannelPushed;

class PushedMessage
{
    const TARGET_APP = 'app';
    const TARGET_CHANNEL = 'channel';
    const TARGET_USER = 'user';
    const TARGET_PUSHED_ID = 'pushed_id';

    const CONTENT_TYPE_SIMPLE = 'simple';
    const CONTENT_TYPE_URL = 'url';

    /**
     * The message to sent.
     * @var
     */
    public $content;

    /**
     * Optional content type.
     * @var
     */
    public $contentType = self::CONTENT_TYPE_SIMPLE;

    /**
     * Optional content type content.
     * @var
     */
    public $contentExtra;

    /**
     * Target type.
     * @var
     */
    public $targetType = self::TARGET_APP;

    /**
     * Target alias.
     * @var
     */
    public $targetAlias;

    /**
     * Users access token.
     * @var
     */
    public $accessToken;

    /**
     * Users Pushed ID.
     * @var
     */
    public $pushedId;

    /**
     * Payload to send to Pushed API.
     * @var
     */
    public $payload;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @param $content
     * @return PushedMessage
     */
    public static function create($content)
    {
        return new static($content);
    }

    /**
     * Send notification to a Pushed app.
     * @return PushedMessage
     */
    public function toApp()
    {
        $this->targetType = self::TARGET_APP;

        return $this;
    }

    /**
     * Send notification to a Pushed Channel.
     * @param $alias
     * @return PushedMessage
     */
    public function toChannel($alias)
    {
        $this->targetType = self::TARGET_CHANNEL;

        $this->targetAlias = $alias;

        return $this;
    }

    /**
     * Send notification to a Pushed User
     * @param $accessToken
     * @param $alias
     * @return PushedMessage
     */
    public function toUser($accessToken, $alias)
    {
        $this->targetType = self::TARGET_USER;

        $this->targetAlias = $alias;

        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Send notification to a User via Pushed ID
     * @param $pushedId
     * @param $alias
     * @return $this
     */
    public function toPushedId($pushedId, $alias)
    {
        $this->targetType = self::TARGET_PUSHED_ID;

        $this->targetAlias = $alias;

        $this->pushedId = $pushedId;

        return $this;
    }

    /**
     * Adds an URL to the notifications
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->contentType = 'url';

        $this->contentExtra = $url;

        return $this;
    }

    /**
     * Convert message to array for pushed service
     */
    public function payload()
    {
        return array_filter([
            'content' => $this->content,
            'content_type' => $this->contentType,
            'content_extra' => $this->contentExtra,
            'target_type' => $this->targetType,
            'target_alias' => $this->targetAlias,
            'access_token' => $this->accessToken,
            'pushed_id' => $this->pushedId,
        ]);
    }
}
