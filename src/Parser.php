<?php

namespace Application;

use Application\Parsers\ParserFactory;
use function Funct\Collection\sortBy;

class Parser
{
    public function parseFile(string $path): array
    {
        $content = $this->getFileContent($path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $parser = ParserFactory::getParser($extension);
        return $parser->parse($content);
    }

    public function getFileContent(string $path): string
    {
        $realPath = realpath($path);

        if ($realPath === false || !file_exists($realPath)) {
            throw new \Exception("File with path: {$path} not found");
        }

        $content = file_get_contents($realPath);

        if ($content === false) {
            throw new \Exception("Failed to read file: {$path}");
        }

        return $content;
    }

    private function buildDiff(array $first, array $second): array
    {
        $allKeys = array_unique(array_merge(array_keys($first), array_keys($second)));
        $allKeys = sortBy($allKeys, fn($key) => $key);

        $diff = [];

        foreach ($allKeys as $key) {
            $inFirst = array_key_exists($key, $first);
            $inSecond = array_key_exists($key, $second);

            $firstValue = $inFirst ? $first[$key] : null;
            $secondValue = $inSecond ? $second[$key] : null;

            if ($inFirst && !$inSecond) {
                $diff[] = ['key' => $key, 'type' => 'removed', 'value' => $firstValue];
            } elseif (!$inFirst && $inSecond) {
                $diff[] = ['key' => $key, 'type' => 'added', 'value' => $secondValue];
            } elseif ($firstValue === $secondValue) {
                $diff[] = ['key' => $key, 'type' => 'unchanged', 'value' => $firstValue];
            } elseif (is_array($firstValue) && is_array($secondValue)) {
                $diff[] = ['key' => $key, 'type' => 'nested', 'children' => $this->buildDiff($firstValue, $secondValue)];
            } else {
                $diff[] = ['key' => $key, 'type' => 'changed', 'oldValue' => $firstValue, 'newValue' => $secondValue];
            }
        }

        return $diff;
    }

    private function formatStylish(array $diff, int $depth = 1): string
    {
        $indent = str_repeat(' ', ($depth - 1) * 4);
        $lines = ["{"];

        foreach ($diff as $node) {
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
                    $nested = $this->formatStylish($node['children'], $depth + 1);
                    $lines[] = $indent . "    {$key}: {$nested}";
                    break;
            }
        }

        $lines[] = $indent . "}";

        return implode("\n", $lines);
    }

    private function stringify($value, int $depth): string
    {
        if (!is_array($value)) {
            if (is_bool($value)) return $value ? 'true' : 'false';
            if ($value === null) return 'null';
            return (string) $value;
        }

        $lines = ["{"];
        foreach ($value as $k => $v) {
            $lines[] = str_repeat(' ', $depth * 4) . "{$k}: " . $this->stringify($v, $depth + 1);
        }
        $lines[] = str_repeat(' ', ($depth - 1) * 4) . "}";

        return implode("\n", $lines);
    }

    public function genDiffFromFiles(string $firstFilePath, string $secondFilePath, string $format = 'stylish'): string
    {
        $firstData = $this->parseFile($firstFilePath);
        $secondData = $this->parseFile($secondFilePath);

        $diffTree = $this->buildDiff($firstData, $secondData);

        return $this->formatStylish($diffTree);
    }
}
