<?php

use PHPUnit\Framework\TestCase;
use Application\Parser;

class YamlTest extends TestCase
{
    public function testGetFileContent(): void
    {
        $path = __DIR__ . "/fixtures/test.yaml";
        $parser = new Parser();
        $content = $parser->getFileContent($path);

        $this->assertIsString($content);
        $this->assertNotEmpty($content);
        $this->assertStringContainsString('name: MyApp', $content);
    }

}