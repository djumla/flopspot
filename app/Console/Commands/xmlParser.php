<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Stations;
use App\TrainNames;

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

    public function getStations($path)
    {
      // Array for possibly duplicates
      $duplicates = [];

      $parsed = $this->parse($path);

      foreach($parsed as $p) {
        // Store stations
        $stations = $p->name;
        array_push($duplicates, $stations);

        foreach($p->xpath("//tracks/track/trains/subtrains") as $destination){
          // Store destinations
          $destinations = $destination->subtrain->destination->destinationName;
          $via = $destination->subtrain->destination->destinationVia->item;

          foreach($via as $v){
            array_push($duplicates, $v);
          }

          // Add stations and destinations to the array
          array_push($duplicates, $destinations);
        }
      }

      // Return result without duplicates
      return array_unique($duplicates);

    }

    public function getTrainNumber($path)
    {
      $trainName = [];

      $parsed = $this->parse($path);

      foreach($parsed as $p) {
        foreach($p->xpath("//tracks/track/trains/train") as $train) {
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

    // Return train names
    return $trainName;

  }

    public function store($path)
    {
      // Stations to save
      $stations = $this->getStations($path);

      // Train names to save
      $trainName = $this->getTrainNumber($path);

      foreach($stations as $station) {
        $sql = new Stations;
        $sql->station = $station;
        $sql->save();
      }
      foreach($trainName as $name) {
        $sql = new TrainNames;
        $sql->name = $name;
        $sql->save();
      }
    }
}
