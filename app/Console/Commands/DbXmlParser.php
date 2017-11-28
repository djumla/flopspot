<?php

namespace App\Console\Commands;

use App\Station;
use App\TrainNumber;
use Illuminate\Console\Command;

class DbXmlParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:parse';

    /**
     * Specify the path, in which the parser should go to
     * Feel free to change the path if the folder structure has changed!
     *
     * @var string
     */
    private $path = 'Services/DBTrainInfo/';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse XML files from $path';

    /**
     * Create a new command instance.
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->store($this->path);
    }

    /**
     * @param $path
     *
     * @return array|void
     *
     * @throws \Exception
     */
    public function parse($path)
    {
        $xmls = [];

        $files = glob($path . "/*.xml");

        if (count($files) === 0) {
            throw new \Exception('No XML files found');

            return;
        }

        foreach ($files as $file) {
            $parse = simplexml_load_file($file);
            $xmls[] = $parse;
        }

        return $xmls;
    }

    /**
     * @param  string $path path to xml files
     *
     * @return array
     */
    public function getStations($path)
    {
        $stations = [];

        $xmls = $this->parse($path);

        foreach ($xmls as $xml) {
            foreach ($xml->xpath("//tracks/track/trains/train") as $train) {
                // Check if train type is equals ICE because thats the only train type which supports WiFi in trains
                if ((string)$train->traintypes->traintype === "ICE") {
                    foreach ($train->xpath("//subtrains/subtrain/destination") as $destination) {
                        $vias = $destination->destinationVia;

                        foreach ($vias as $via) {
                            if (strlen($via) !== 0) {
                                $stations[trim((string)$via)] = (string)$via;
                            }
                        }

                        if (strlen($destination->destinationName) !== 0) {
                            $stations[trim((string)$destination->destinationName)] = (string)$destination->destinationName;
                        }
                    }
                }
            }
        }

        return $stations;
    }

    /**
     * @param  string $path
     *
     * @return array
     */
    public function getTrainNumbers($path)
    {
        $trainNumbers = [];

        $xmls = $this->parse($path);

        foreach ($xmls as $xml) {
            foreach ($xml->xpath("//tracks/track/trains/train") as $train) {
                if ((string)$train->traintypes->traintype === "ICE") {
                    $number = $train->trainNumbers->trainNumber;

                    $type = $train->traintypes->traintype;
                    /**
                     * This line is based on the database structure
                     * There is no table for train types because there is just the ICE which supports Wifi in trains
                     * In this case, train type and number gonna be stored as a whole (Type + Number = ICE 200)
                     */
                    $trainNumbers[] = $type . " " . $number;
                }
            }
        }

        return array_unique($trainNumbers);
    }

    /**
     * @param  string $path
     *
     * @return void
     */
    public function store($path)
    {
        $stations = $this->getStations($path);

        $trainNumbers = $this->getTrainNumbers($path);

        foreach ($stations as $station) {
            $db = new Station;
            $db->station = $station;
            $db->save();
        }

        foreach ($trainNumbers as $trainNumber) {
            $db = new TrainNumber;
            $db->trainNumber = $trainNumber;
            $db->save();
        }
    }
}
