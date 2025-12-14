<?php

namespace Application;

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

    private function genDiff(array $first, array $second): array
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
                $diff[] = ['key' => $key, 'type' => 'nested', 'children' => $this->genDiff($firstValue, $secondValue)];
            } else {
                $diff[] = ['key' => $key, 'type' => 'changed', 'oldValue' => $firstValue, 'newValue' => $secondValue];
            }
        }

        return $diff;
    }

    public function genDiffFromFiles(string $firstFilePath, string $secondFilePath, string $format = 'stylish'): string
    {
        $firstData = $this->parseFile($firstFilePath);
        $secondData = $this->parseFile($secondFilePath);

        $diffTree = $this->genDiff($firstData, $secondData);

        return FormatterFactory::format($diffTree, $format);
    }
}
