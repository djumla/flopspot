<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\TwitterAPIConnection;

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
}