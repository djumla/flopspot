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
      // Store path
      $path = $this->option('path');
      $this->store($path);
    }

    public function parse($path)
    {
      // Declare array
      $xml = [];

      // Find XML files
      $files = glob($path."/*.xml");

      // Check existence of files
      if($files) {
        // Iterate through the directory and load the xml files
        foreach($files as $file) {
          $parse = simplexml_load_file($file);
          array_push($xml, $parse);
        }

        return $xml;

      } else {
        echo 'No XML files found!';
      }
    }

    public function getStation($path)
    {
      $station = [];

      $parsed = $this->parse($path);

      foreach($parsed as $p) {
        foreach($p->xpath("//tracks/track/trains/train") as $train) {
          if($train->traintypes->traintype == "ICE") {
            foreach($train->xpath("//subtrains/subtrain/destination") as $destination) {
              // Store destinations
              $via = $destination->destinationVia;

              foreach($via as $v){
                if(strlen($v) != 0) {
                  $station[trim((string) $v)] = (string) $v;
                }
              }
              if(strlen($destination->destinationName) != 0) {
                // Add stations and destinations to the array
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

      foreach($parsed as $p) {
        foreach($p->xpath("//tracks/track/trains/train") as $train) {
          if($train->traintypes->traintype == "ICE") {
              // Store train numbers
              $number = $train->trainNumbers->trainNumber;

              // Store their train type
              $type = $train->traintypes->traintype;

              // Combine type and numbers to get the full train name
              $combine = $type." ".$number;

              // Add the combined version to the array
              array_push($trainName, $combine);
            }
          }
        }

        return array_values(array_unique($trainName));

      }

      public function store($path)
      {
        // Stations to save
        $stations = $this->getStation($path);

        // Train names to save
        $trainName = $this->getTrainName($path);

        foreach($stations as $station) {
          $sql = new Station;
          $sql->station = $station;
          $sql->save();
        }
        foreach($trainName as $name) {
          $sql = new TrainNumber;
          $sql->trainNumber = $name;
          $sql->save();
        }
      }
}
