<?php

namespace App\Service;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterAPIConnection
{
    /**
     * @return \GuzzleHttp\Client
     */
    public function connection()
    {
        $consumerKey = env('TWITTER_CONSUMER_KEY');
        $consumerSecret = env('TWITTER_CONSUMER_SECRET');
        $token = env('TWITTER_TOKEN');
        $tokenSecret = env('TWITTER_TOKEN_SECRET');
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
