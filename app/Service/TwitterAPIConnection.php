<?php

namespace App\Service;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterAPIConnection
{
    public function connection()
    {
        $consumerKey = config('apiKeys.twitterAPI.consumerKey');
        $consumerSecret = config('apiKeys.twitterAPI.consumerSecret');
        $token = config('apiKeys.twitterAPI.token');
        $tokenSecret = config('apiKeys.twitterAPI.tokenSecret');
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret,
            'token' => $token,
            'token_secret' => $tokenSecret,
        ]);
        $stack->push($middleware);

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
        ]);

        return $client;
    }
}
