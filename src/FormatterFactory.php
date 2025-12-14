<?php

namespace Application;

use Application\Formatters\PlainFormatter;
use Application\Formatters\StylishFormatter;

class FormatterFactory
{
    public static function format(array $diffTree, string $format): string
    {
        switch ($format) {
            case 'plain':
                $formatter = new PlainFormatter();
                break;
            case 'stylish':
                $formatter = new StylishFormatter();
                break;
            default:
                throw new \Exception("Unknown format: {$format}");
        }

        return $formatter->format($diffTree);
    }

}