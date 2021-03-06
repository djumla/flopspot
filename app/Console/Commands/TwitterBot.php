<?php

namespace App\Console\Commands;

use App\TwitterStatus;
use Illuminate\Console\Command;
use App\Service\TwitterAPIConnection;
use App\Http\Controllers\API\TwitterController;

class TwitterBot extends Command
{
    /**
     * @var TwitterStatus
     */
    protected $statusModel;

    /**
     * @var TwitterAPIConnection
     */
    protected $conn;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to send advertising for flopspot via twitter';

    /**
     * Create a new command instance.
     *
     * @param TwitterStatus $statusModel
     * @param TwitterAPIConnection $conn
     */
    public function __construct(TwitterStatus $statusModel, TwitterAPIConnection $conn)
    {
        parent::__construct();

        $this->statusModel = $statusModel;
        $this->conn = $conn;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->storeStatus();
        $this->pokeUser();
        $this->deleteStatus();
    }

    /**
     * Searches for tweets with specific tags like ice or WiFi.
     *
     * Returns response as json string
     *
     * @return string
     */
    public function findTagsRelatedTweets()
    {
        $response = $this->conn->connection()->request(
            'GET',
            'search/tweets.json?q=ICE%2C%20WLAN%20OR%20WiFi%2C%20%20ICE&lang=de&result_type=recent&count=5',
            ['auth' => 'oauth']
        );

        $body = (string)$response->getBody();

        return $body;
    }

    /**
     * Based on the response body, stores the status id and the screen_name of the author who wrote the status
     *
     * @return array
     */
    public function getStatuses()
    {
        $statuses = json_decode($this->findTagsRelatedTweets(), true);
        $tweets = [];

        foreach ($statuses["statuses"] as $status) {
            if ($status['metadata']['iso_language_code'] === 'de' && $status['user']['lang'] === 'de') {
                $tweets[] = [
                  'author' => $status['user']['screen_name'],
                  'id' => $status['id']
              ];
            }
        }

        return $tweets;
    }

    /**
     * Stores username and tweet id of the status author
     *
     * @return void
     */
    public function storeStatus()
    {
        $statuses = $this->getStatuses();

        foreach ($statuses as $status) {
            if ($status['author'] === "DB_Bahn") {
                continue;
            }

            if (!count($this->statusModel->checkIfUserRegistered('@' . $status['author']))) {
                $model = $this->statusModel->newInstance();

                $model->status_id = $status['id'];
                $model->status_author = '@' . $status['author'];

                $model->save();
            }
        }
    }

    /**
     * Pokes the user, if he has not already
     *
     * @return void
     */
    public function pokeUser()
    {
        if (count($this->statusModel->getNotPoked())) {
            foreach ($this->statusModel->getNotPoked() as $notPoked) {
                $response = $this->conn->connection()->request(
                    'POST',
                    'statuses/update.json',
                    [
                        'auth' => 'oauth',

                        'form_params' => [
                            'status' => $notPoked['status_author'] . ' ' . config('projectDescription.description'),
                            'in_reply_to_status_id' => $notPoked['status_id']
                        ]
                    ]
                );

                if ($response) {
                    $this->statusModel->updateStatus($notPoked['status_author']);
                }
            }
        }
    }

    /**
     * @return void
     */
    public function deleteStatus()
    {
        $this->statusModel->deletePokedStatusEveryMonth();
    }
}
