<?php

namespace Application\Formatters;

interface FormatterInterface
{
    public function format(array $diff, string $parent = ''): string;
}
