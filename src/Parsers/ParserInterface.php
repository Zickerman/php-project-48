<?php

namespace Application\Parsers;

interface ParserInterface
{
    public function parse(string $content): array;
}
