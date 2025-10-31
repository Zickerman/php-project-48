<?php

namespace Application;

use function Funct\Collection\sortBy;

class Parser
{
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

    public function parseFile(string $path): array
    {
        $content = $this->getFileContent($path);

        $data = json_decode($content, true);

        if ($data === null) {
            throw new \Exception("Can't parse JSON from: {$path}");
        }

        return $data;
    }

    public function genDiff(array $firstFileData, array $secondFileData): string
    {
        $allKeys = array_unique(array_merge(array_keys($firstFileData), array_keys($secondFileData)));
        $allKeys = sortBy($allKeys, fn($key) => $key);

        $diffLines = ["\n {"];

        foreach ($allKeys as $key) {
            $inFirst = array_key_exists($key, $firstFileData);
            $inSecond = array_key_exists($key, $secondFileData);

            if ($inFirst && !$inSecond) {
                $diffLines[] = "  - {$key}: " . $this->stringify($firstFileData[$key]);
            } elseif (!$inFirst && $inSecond) {
                $diffLines[] = "  + {$key}: " . $this->stringify($secondFileData[$key]);
            } elseif ($firstFileData[$key] === $secondFileData[$key]) {
                $diffLines[] = "    {$key}: " . $this->stringify($firstFileData[$key]);
            } else {
                $diffLines[] = "  - {$key}: " . $this->stringify($firstFileData[$key]);
                $diffLines[] = "  + {$key}: " . $this->stringify($secondFileData[$key]);
            }
        }

        $diffLines[] = "} \n";

        return implode("\n", $diffLines);
    }

    private function stringify($value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if ($value === null) {
            return 'null';
        }
        return (string) $value;
    }

    public function genDiffFromFiles(string $firstFilePath, string $secondFilePath): string
    {
        $firstData = $this->parseFile($firstFilePath);
        $secondData = $this->parseFile($secondFilePath);

        return $this->genDiff($firstData, $secondData);
    }
}
