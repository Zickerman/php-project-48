<?php

use PHPUnit\Framework\TestCase;
use Application\Parser;

class JsonFlatTest extends TestCase
{
    public function testGetFileContent(): void
    {
        $path = __DIR__ . "/fixtures/flatJson1.json";
        $parser = new Parser();

        $content = $parser->getFileContent($path);
        $this->assertJsonStringEqualsJsonString(json_encode(["host" => "hexlet.io", "timeout" => 50, "proxy" => "123.234.53.22", "follow" => false]), $content);
    }

}