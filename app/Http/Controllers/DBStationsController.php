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
      $root = base_path();
      $files = glob($root."/Services/DBTrainInfo/*.xml");

      foreach ($files as $file) {
        $xml = simplexml_load_file($file);
        var_dump($xml);
      }
    }
}
