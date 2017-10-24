<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Service\TwitterAPIConnection;
use App\Http\Controllers\Controller;

class TwitterController extends Controller
{
    protected $conn;
    public function __construct(TwitterAPIConnection $conn)
    {
        $this->conn = $conn;
    }

    public function getTweets()
    {
        $response = $this->conn->connection()->request(
            'GET',
            'search/tweets.json?l=&q=from%3ADB_INFO&src=typd',
            ['auth' => 'oauth']
        );
        $body = $response->getBody();
        echo $body;
    }
}
