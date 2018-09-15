<?php

namespace PendoNL\LaravelNotificationsChannelPushed\Tests;

use PendoNL\LaravelNotificationsChannelPushed\PushedMessage;

class PushedMessageTest extends \PHPUnit_Framework_TestCase
{
    private $message;

    public function __construct()
    {
        $this->message = PushedMessage::create('Hello');
    }

    /** @test */
    public function message_can_be_instantiated_with_text()
    {
        $this->assertEquals('Hello', $this->message->content);
    }

    /** @test */
    public function new_message_is_of_simple_type()
    {
        $this->assertEquals(PushedMessage::CONTENT_TYPE_SIMPLE, $this->message->contentType);
    }

    /** @test */
    public function new_message_is_targetted_for_app()
    {
        $this->assertEquals(PushedMessage::TARGET_APP, $this->message->targetType);
    }

    /** @test */
    public function message_can_have_an_url()
    {
        $this->message->setUrl('https://pendo.nl');

        $this->assertEquals(PushedMessage::CONTENT_TYPE_URL, $this->message->contentType);
        $this->assertEquals('https://pendo.nl', $this->message->contentExtra);
    }

    /** @test */
    public function message_can_be_targetted_to_channel()
    {
        $this->message->toChannel('channel-alias');

        $this->assertEquals(PushedMessage::TARGET_CHANNEL, $this->message->targetType);
        $this->assertEquals('channel-alias', $this->message->targetAlias);
    }

    /** @test */
    public function message_can_be_targetted_to_user()
    {
        $this->message->toUser('access-token', 'user-alias');

        $this->assertEquals(PushedMessage::TARGET_USER, $this->message->targetType);
        $this->assertEquals('access-token', $this->message->accessToken);
        $this->assertEquals('user-alias', $this->message->targetAlias);
    }

    /** @test */
    public function message_can_be_targetted_to_pushed_id()
    {
        $this->message->toPushedId('pushed-id', 'user-alias');

        $this->assertEquals(PushedMessage::TARGET_PUSHED_ID, $this->message->targetType);
        $this->assertEquals('pushed-id', $this->message->pushedId);
        $this->assertEquals('user-alias', $this->message->targetAlias);
    }

    /** @test */
    public function message_payload_for_app()
    {
        $payload = $this->message->toApp()->payload();

        $expected = [
            'content' => 'Hello',
            'content_type' => 'simple',
            'target_type' => PushedMessage::TARGET_APP,
        ];

        $this->assertEquals($expected, $payload);
    }

    /** @test */
    public function message_payload_for_channel()
    {
        $payload = $this->message->toChannel('test-channel')->payload();

        $expected = [
            'content' => 'Hello',
            'content_type' => 'simple',
            'target_type' => PushedMessage::TARGET_CHANNEL,
            'target_alias' => 'test-channel',
        ];

        $this->assertEquals($expected, $payload);
    }

    /** @test */
    public function message_payload_for_user()
    {
        $payload = $this->message->toUser('access-token', 'user-alias')->payload();

        $expected = [
            'content' => 'Hello',
            'content_type' => 'simple',
            'target_type' => PushedMessage::TARGET_USER,
            'target_alias' => 'user-alias',
            'access_token' => 'access-token',
        ];

        $this->assertEquals($expected, $payload);
    }

    /** @test */
    public function message_payload_for_pushed_id()
    {
        $payload = $this->message->toPushedId('pushed-id', 'user-alias')->payload();

        $expected = [
            'content' => 'Hello',
            'content_type' => 'simple',
            'target_type' => PushedMessage::TARGET_PUSHED_ID,
            'target_alias' => 'user-alias',
            'pushed_id' => 'pushed-id',
        ];

        $this->assertEquals($expected, $payload);
    }

    /** @test */
    public function message_payload_for_notification_with_url()
    {
        $payload = $this->message->setUrl('https://pendo.nl')->payload();

        $expected = [
            'content' => 'Hello',
            'content_type' => 'url',
            'content_extra' => 'https://pendo.nl',
            'target_type' => PushedMessage::TARGET_APP,
        ];

        $this->assertEquals($expected, $payload);
    }
}
