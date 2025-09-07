<?php

namespace Application;

class Parser
{
    public function getFileContent(string $path): string
    {
        if (!file_exists($path)) {
            throw new \Exception("File with path: {$path} not found");
        }

        $content = file_get_contents($path);

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
}
