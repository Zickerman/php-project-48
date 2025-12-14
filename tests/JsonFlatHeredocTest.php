<?php

use PHPUnit\Framework\TestCase;
use Application\Parser;

class JsonFlatHeredocTest extends TestCase
{
    public function testGenDiffFlat(): void
    {
        $firstFilePath = __DIR__ . "/fixtures/flatJson1.json";
        $secondFilePath = __DIR__ . "/fixtures/flatJson2.json";
        $parser = new Parser();

        $parseContent = $parser->genDiffFromFiles($firstFilePath, $secondFilePath);
        $expectedContent = <<<asd
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
asd;

        $this->assertSame(trim($expectedContent), trim($parseContent));
    }

}