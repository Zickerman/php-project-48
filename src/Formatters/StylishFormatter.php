<?php

namespace Application\Formatters;

class StylishFormatter implements FormatterInterface
{
    public function format(array $diff, string $parent = ''): string
    {
        return $this->formatNodes($diff, 1);
    }

    private function formatNodes(array $nodes, int $depth): string
    {
        $indent = str_repeat(' ', ($depth - 1) * 4);
        $lines = ["{"];

        foreach ($nodes as $node) {
            $type = $node['type'];
            $key = $node['key'];

            switch ($type) {
                case 'added':
                    $lines[] = $indent . "  + {$key}: " . $this->stringify($node['value'], $depth + 1);
                    break;

                case 'removed':
                    $lines[] = $indent . "  - {$key}: " . $this->stringify($node['value'], $depth + 1);
                    break;

                case 'unchanged':
                    $lines[] = $indent . "    {$key}: " . $this->stringify($node['value'], $depth + 1);
                    break;

                case 'changed':
                    $lines[] = $indent . "  - {$key}: " . $this->stringify($node['oldValue'], $depth + 1);
                    $lines[] = $indent . "  + {$key}: " . $this->stringify($node['newValue'], $depth + 1);
                    break;

                case 'nested':
                    $nested = $this->formatNodes($node['children'], $depth + 1);
                    $lines[] = $indent . "    {$key}: {$nested}";
                    break;
            }
        }

        $lines[] = $indent . "}";
        return implode("\n", $lines);
    }

    private function stringify($value, int $depth = 1): string
    {
        if (is_array($value)) {
            $lines = ["{"];
            foreach ($value as $k => $v) {
                $lines[] = str_repeat(' ', $depth * 4) . "{$k}: " . $this->stringify($v, $depth + 1);
            }
            $lines[] = str_repeat(' ', ($depth - 1) * 4) . "}";
            return implode("\n", $lines);
        }

        if ($value === '') return '';
        if (is_bool($value)) return $value ? 'true' : 'false';
        if ($value === null) return 'null';
        return (string)$value;
    }
}
