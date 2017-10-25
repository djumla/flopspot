<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Station;
use App\TrainNumber;

class DbXmlParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /**
     * The path parameter is completly useless because this parser can't parse everything its directed to.
     * This class should be more named like "DbXmlParser" (DB = Deutsche Bahn)
    */
    protected $signature = 'xml:parse';

    /**
      * Specify the path, in which the parser should go to
      * Feel free to change the path if the folder structure has changed!
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
     *
     * @return void
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
    * @param  string $path  path to XMLs
    *
    * @return Array
    **/
    public function parse($path)
    {
        $xmls = [];

        $files = glob($path . "/*.xml");

        if (count($files) === 0) {
            echo 'No XML files found';

            return;
        }

        foreach ($files as $file) {
            $parse = simplexml_load_file($file);
            $xmls[] = $parse;
        }

        return $xmls;
    }

    /**
      * This method and the same for getTrainName iterate through the entire XML files
      * This needs to be done because the XML files are nested as fuck. Like every tag is nested in another and so on..
      * In fact, those two methods(getStation, getTrainName) iterate through the entire XML files unless they found the information they need
    */
    public function getStations($path)
    {
        $stations = [];

        $xmls = $this->parse($path);

        foreach ($xmls as $xml) {
            foreach ($xml->xpath("//tracks/track/trains/train") as $train) {
                // Check if train type is equals ICE because thats the only train type which supports WiFi in trains
                if ((string) $train->traintypes->traintype === "ICE") {
                    foreach ($train->xpath("//subtrains/subtrain/destination") as $destination) {
                        $vias = $destination->destinationVia;

                        foreach ($vias as $via) {
                            if (strlen($via) !== 0) {
                                $stations[trim((string) $via)] = (string) $via;
                            }
                        }
                        if (strlen($destination->destinationName) !== 0) {
                            $stations[trim((string) $destination->destinationName)] = (string) $destination->destinationName;
                        }
                    }
                }
            }
        }

        return $stations;
    }

    public function getTrainNumbers($path)
    {
        $trainNumbers = [];

        $xmls = $this->parse($path);

        foreach ($xmls as $xml) {
            foreach ($xml->xpath("//tracks/track/trains/train") as $train) {
                if ((string) $train->traintypes->traintype === "ICE") {
                    $numbers = $train->trainNumbers->trainNumber;

                    $types = $train->traintypes->traintype;

                    /**
                      * This line is based on the database structure
                      * There is no table for train types because there is just the ICE which supports Wifi in trains
                      * In this case, train type and number gonna be stored as a whole (Type + Number = ICE 200)
                    */
                    $trainNumbers[] = $types." ".$numbers;
                }
            }
        }

        return $trainNumbers;
    }

    public function store($path)
    {
        $stations = $this->getStations($path);

        $trainNumbers = $this->getTrainNumbers($path);

        foreach ($stations as $station) {
            $db = new Station;
            $db->station= $station;
            $db->save();
        }
        foreach ($trainNumbers as $trainNumber) {
            $db = new TrainNumber;
            $db->trainNumber = $trainNumber;
            $db->save();
        }
    }
}
