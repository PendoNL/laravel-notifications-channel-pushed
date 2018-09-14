<?php

namespace PendoNL\LaravelNotificationsChannelPushed;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class Pushed
{
    /**
     * Pushed API root URL.
     * @var string
     */
	protected $root = 'https://api.pushed.co/1/push';

    /**
     * Pushed App key.
     * @var
     */
	protected $appKey;

    /**
     * Pushed App Secret.
     * @var
     */
	protected $appSecret;

    /**
     * Pushed
     * @var
     */
	protected $pushed;

    /**
     * Pushed constructor.
     * @param $app_key
     * @param $app_secret
     * @param HttpClient $httpClient
     */
	public function __construct(string $appKey, string $appSecret, HttpClient $httpClient)
    {
        $this->appKey = $appKey;

        $this->appSecret = $appSecret;

        $this->httpClient = $httpClient;
    }

    /**
     * Send request to Pushed API.
     *
     * @param  array  $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send($params)
    {
        try {
            return $this->httpClient->post($this->root, [
                'form_params' => array_merge([
                    'app_key' => $this->appKey,
                    'app_secret' => $this->appSecret
                ], $params)
            ]);
        } catch (ClientException $exception) {
            dd($exception->getMessage());
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}