<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DBStationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->open();
    }

    public function open()
    {
      $path = base_path()."/Services/DBTrainInfo/";
      $parsed = $this->parse($path);

      foreach($parsed as $p) {
        foreach($p->tracks->track->trains->train->trainNumbers as $trainNumbers) {
          var_dump($trainNumbers->trainNumber);
        }
        foreach($p->tracks->track->trains->train->subtrains->subtrain->destination as $destination){
          var_dump($destination->destinationName);
        }
      }



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
}
