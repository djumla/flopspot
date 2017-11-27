<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\TwitterAPIConnection;
use App\TwitterStatus;

class TwitterController extends Controller
{
    protected $conn;

    /**
     * @param TwitterAPIConnection $conn
     */
    public function __construct(TwitterAPIConnection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return object
     */
    public function getTweets()
    {
        $response = $this->conn->connection()->request(
            'GET',
            'search/tweets.json?l=&q=from%3ADB_INFO&src=typd',
            ['auth' => 'oauth']
        );

        $body = $response->getBody();

        return response($body);
    }

    public function findTagsRelatedTweets()
    {
        $response = $this->conn->connection()->request(
            'GET',
            'search/tweets.json?l=&q=ice%2C%20wlan%20OR%20deutsche%20bahn%2C%20OR%20db%2C%20OR%20wifi&src=typd',
            ['auth' => 'oauth']
        );

        $body = (string)$response->getBody();

        return $body;
    }

    public function getStatuses()
    {
        $statuses = json_decode($this->findTagsRelatedTweets(), true);
        $tweets = [];

        foreach ($statuses["statuses"] as $status) {
            $tweets[] = [
                'author' => $status['user']['screen_name'],
                'id' => $status['id']
            ];
        }

        return $tweets;
    }
}