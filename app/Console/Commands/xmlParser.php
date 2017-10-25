<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Station;
use App\TrainNumber;

class xmlParser extends Command
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
    protected $signature = 'xml:parse {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse XML';

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
        $path = $this->option('path');
        $this->store($path);
    }

    public function parse($path)
    {
        $xml = [];

        $files = glob($path."/*.xml");

        if ($files) {
            foreach ($files as $file) {
                $parse = simplexml_load_file($file);
                array_push($xml, $parse);
            }

            return $xml;
        } else {
            echo 'No XML files found!';
        }
    }
    /**
      * This method and the same for getTrainName iterate through the entire XML files
      * This needs to be done because the XML files are nested as fuck. Like every tag is nested in another and so on..
      * In fact, those two methods(getStation, getTrainName) iterate through the entire XML files unless they found the information they need
    */
    public function getStation($path)
    {
        $station = [];

        $parsed = $this->parse($path);

        foreach ($parsed as $p) {
            foreach ($p->xpath("//tracks/track/trains/train") as $train) {
                // Check if train type is equals ICE because thats the only train type which supports WiFi in trains
                if ($train->traintypes->traintype == "ICE") {
                    foreach ($train->xpath("//subtrains/subtrain/destination") as $destination) {
                        $via = $destination->destinationVia;

                        foreach ($via as $v) {
                            if (strlen($v) != 0) {
                                $station[trim((string) $v)] = (string) $v;
                            }
                        }
                        if (strlen($destination->destinationName) != 0) {
                            $station[trim((string) $destination->destinationName)] = (string) $destination->destinationName;
                        }
                    }
                }
            }
        }

        return $station;
    }

    public function getTrainName($path)
    {
        $trainName = [];

        $parsed = $this->parse($path);

        foreach ($parsed as $p) {
            foreach ($p->xpath("//tracks/track/trains/train") as $train) {
                if ($train->traintypes->traintype == "ICE") {
                    $number = $train->trainNumbers->trainNumber;

                    $type = $train->traintypes->traintype;
                    /**
                      * This line is based on the database structure
                      * There is no table for train types because there is just the ICE which supports Wifi in trains
                      * In this case, train type and number gonna be stored as a whole
                    */
                    $combine = $type." ".$number;

                    array_push($trainName, $combine);
                }
            }
        }

        return array_values(array_unique($trainName));
    }

    public function store($path)
    {
        $stations = $this->getStation($path);

        $trainName = $this->getTrainName($path);

        foreach ($stations as $station) {
            $sql = new Station;
            $sql->station = $station;
            $sql->save();
        }
        foreach ($trainName as $name) {
            $sql = new TrainNumber;
            $sql->trainNumber = $name;
            $sql->save();
        }
    }
}
