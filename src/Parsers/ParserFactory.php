<?php

namespace Application\Parsers;

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
