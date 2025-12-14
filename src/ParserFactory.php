<?php

namespace Application;

use Application\Parsers\JsonParser;
use Application\Parsers\ParserInterface;
use Application\Parsers\YamlParser;

class ParserFactory
{
    public static function getParser(string $extension): ParserInterface
    {
        switch ($extension) {
            case 'json':
                return new JsonParser();
            case 'yml':
            case 'yaml':
                return new YamlParser();
            default:
                throw new \Exception("Unsupported extension: {$extension}");
        }
    }
}
