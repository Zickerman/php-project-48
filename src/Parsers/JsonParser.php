<?php

namespace Application\Parsers;

class JsonParser implements ParserInterface
{
    public function parse(string $content): array
    {
        $data = json_decode($content, true);
        if (!$data) {
            throw new \Exception("Invalid JSON content");
        }
        return $data;
    }
}