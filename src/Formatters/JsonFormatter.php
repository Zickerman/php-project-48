<?php

namespace Application\Formatters;

class JsonFormatter implements FormatterInterface
{
    public function format(array $diff, string $parent = ''): string
    {
        $result = $this->formatNodes($diff);
        return json_encode($result, JSON_PRETTY_PRINT);
    }

    private function formatNodes(array $nodes): array
    {
        $formatted = [];

        foreach ($nodes as $node) {
            $key = $node['key'];
            $type = $node['type'];

            switch ($type) {
                case 'nested':
                    $formatted[$key] = [
                        'type' => 'nested',
                        'children' => $this->formatNodes($node['children']),
                    ];
                    break;

                case 'added':
                    $formatted[$key] = [
                        'type' => 'added',
                        'value' => $node['value'],
                    ];
                    break;

                case 'removed':
                    $formatted[$key] = [
                        'type' => 'removed',
                        'value' => $node['value'],
                    ];
                    break;

                case 'changed':
                    $formatted[$key] = [
                        'type' => 'changed',
                        'oldValue' => $node['oldValue'],
                        'newValue' => $node['newValue'],
                    ];
                    break;

                case 'unchanged':
                    $formatted[$key] = [
                        'type' => 'unchanged',
                        'value' => $node['value'],
                    ];
                    break;
            }
        }

        return $formatted;
    }
}
