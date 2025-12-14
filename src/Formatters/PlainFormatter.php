<?php

namespace Application\Formatters;

class PlainFormatter implements FormatterInterface
{
    public function format(array $diff, string $parent = ''): string
    {
        $lines = [];
        foreach ($diff as $node) {
            $fullPath = $parent === '' ? $node['key'] : "{$parent}.{$node['key']}";
            $type = $node['type'];

            switch ($type) {
                case 'added':
                    $lines[] = "Property '{$fullPath}' was added with value: " . $this->stringify($node['value']);
                    break;
                case 'removed':
                    $lines[] = "Property '{$fullPath}' was removed";
                    break;
                case 'changed':
                    $lines[] = "Property '{$fullPath}' was updated. From " . $this->stringify($node['oldValue'])
                        . " to " . $this->stringify($node['newValue']);
                    break;
                case 'nested':
                    $lines[] = $this->format($node['children'], $fullPath);
                    break;
                case 'unchanged':
                    break;
            }
        }
        return implode("\n", $lines);
    }

    private function stringify($value): string
    {
        if (is_array($value)) return '[complex value]';
        if (is_string($value)) return "'{$value}'";
        if ($value === null) return 'null';
        if (is_bool($value)) return $value ? 'true' : 'false';
        return (string)$value;
    }
}
