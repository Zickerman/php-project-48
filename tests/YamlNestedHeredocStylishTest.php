<?php

use PHPUnit\Framework\TestCase;
use Application\Parser;

class YamlNestedHeredocStylishTest extends TestCase
{
    public function testGenDiffNested(): void
    {
        $firstFilePath = __DIR__ . "/fixtures/nestedYaml1.yaml";
        $secondFilePath = __DIR__ . "/fixtures/nestedYaml2.yaml";
        $parser = new Parser();

        $parseContent = $parser->genDiffFromFiles($firstFilePath, $secondFilePath);
        $expectedContent = <<<asd
{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}
asd;

        $this->assertSame(trim($expectedContent), trim($parseContent));
    }

}