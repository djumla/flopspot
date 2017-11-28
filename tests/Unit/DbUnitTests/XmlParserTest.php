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

    private $path = 'tests/Mocks/XMLs/';
    private $pathToEmptyFile = 'tests/Mocks/XMLs/EmptyOrUncomplete/Empty.xml';
    private $xmlParser;
    private $xmls;

    public function setUp()
    {
        $this->xmlParser = new DbXmlParser();
        $this->xmls = $this->xmlParser->parse($this->path);
    }

    public function testParserReturnsSimpleXmlObjects()
    {
        $this->assertInstanceOf('\SimpleXMLElement', $this->xmls[0]);
        $this->assertInstanceOf('\SimpleXMLElement', $this->xmls[1]);
    }

    public function testParserReturnsAnArray()
    {
        $this->assertTrue(is_array($this->xmls));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No XML files found
     */
    public function testParserThrowsExceptionWithoutXmls()
    {
        $this->xmlParser->parse($this->pathToEmptyFile);
    }
}
