<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Console\Commands\DbXmlParser;

class GetStationsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    private $path = 'tests/Mocks/XMLs';

    public function testAccuracyOfReturnedStations()
    {
        $obj = new DbXmlParser;
        $station = $obj->getStations($this->path);

        $this->assertArraySubset(
            [
                'Itzehoe/Wrist' => 'Itzehoe/Wrist',
                'Westerland(Sylt)' => 'Westerland(Sylt)',
                'Kiel' => 'Kiel',
                'Kiel Hbf' => 'Kiel Hbf',
                'Flensburg' => 'Flensburg',
                'Itzehoe' => 'Itzehoe',
                'Westerland' => 'Westerland',
                'Aarhus' => 'Aarhus',
                'Westerland (Sylt)' => 'Westerland (Sylt)'
            ], $station
        );
    }
}
