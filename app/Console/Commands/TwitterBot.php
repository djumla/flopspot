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
     * @return void
     */
    public function pokeUser()
    {
        if (count($this->statusModel->getNotPoked())) {
            foreach ($this->statusModel->getNotPoked() as $notPoked) {
                $response = $this->conn->connection()->request('POST', 'statuses/update.json', [
                        'auth' => 'oauth',

                        'form_params' => [
                            'status' => $notPoked['status_author'] . ' Hallo, einfach ignorieren :D',
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
        $this->statusModel->deleteStatus();
    }

    /**
     * @return void
     */
    public function storeStatus()
    {
        $twitterController = new TwitterController();

        $statuses = $twitterController->getStatuses();

        foreach ($statuses as $status) {
            $db = new TwitterStatus;

            if (!count($this->statusModel->checkIfUserRegistered('@' . $status['author']))) {
                $db->status_id = $status['id'];
                $db->status_author = '@' . $status['author'];

                $db->save();
            }
        }
    }
}
