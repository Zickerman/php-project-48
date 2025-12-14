<?php

namespace Application\Parsers;

use Symfony\Component\Yaml\Yaml;

class YamlParser implements ParserInterface
{
    public function parse(string $content): array
    {
        $data = Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
        if (!$data) {
            throw new \Exception("Invalid Yaml content");
        }
        return json_decode(json_encode($data), true);
    }
}
