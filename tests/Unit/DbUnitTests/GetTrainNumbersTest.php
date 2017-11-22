<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Console\Commands\DbXmlParser;

class GetTrainNumbersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    private $path = 'tests/XMLs/';

    public function testGetTrainNumbers()
    {
        $obj = new DbXmlParser;
        $trains = $obj->getTrainNumbers($this->path);

        $this->assertEquals([
            '0' => 'ICE 906',
            '1' => 'ICE 1206',
            '2' => 'ICE 1188',
            '4' => 'ICE 772',
            '5' => 'ICE 880',
            '6' => 'ICE 74',
            '7' => 'ICE 1274',
            '8' => 'ICE 1094',
            '9' => 'ICE 534'
        ], $trains);
    }
}
