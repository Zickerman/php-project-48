<?php

use PHPUnit\Framework\TestCase;
use Application\Parser;

class JsonTest extends TestCase
{
    public function testGetFileContent(): void
    {
        $path = __DIR__ . "/fixtures/test.json";
        $parser = new Parser();

        $content = $parser->getFileContent($path);
        $this->assertJsonStringEqualsJsonString(json_encode(["host" => "hexlet.io", "timeout" => 50, "proxy" => "123.234.53.22", "follow" => false]), $content);
    }

}