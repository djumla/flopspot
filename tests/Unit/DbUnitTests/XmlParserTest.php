<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Console\Commands\DbXmlParser;
use \XMLReader;

class XmlParserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    private $path = 'tests/XMLs/';
    private $pathToEmptyFile = 'tests/XMLs/EmptyOrUncomplete/Empty.xml';

    public function testParser()
    {
        $obj = new DbXmlParser();
        $xmls = $obj->parse($this->path);

        $this->assertNotEmpty($xmls);
        /**
         * Must return an array full of SimpleXMLElement objects
         */
        $this->assertTrue(is_array($xmls));
        /**
         * Each file must contain objects of SimpleXMLElements.
         */
        $this->assertInternalType('object', $xmls[0]);
        $this->assertInternalType('object', $xmls[1]);
    }

    public function testEmptyPaths()
    {
        $obj = new DbXmlParser();
        $xmls = $obj->parse($this->pathToEmptyFile);

        $this->assertEmpty($xmls);

        return $xmls;
    }
}
