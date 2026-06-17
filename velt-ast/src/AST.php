<?php

namespace VeltAst;

use VeltAst\Nodes\VStack;
use VeltAst\Nodes\HStack;
use VeltAst\Nodes\Text;
use VeltAst\Nodes\Button;
use VeltAst\Nodes\Input;
use VeltAst\Nodes\Container;

class AST
{
    public function __construct(
        public string $view,
        public NodeInterface $root,
        public array $meta = []
    ) {}

    public function toArray(): array
    {
        return [
            'screen' => $this->view,
            'components' => [$this->root->toArray()],
            'meta' => $this->meta
        ];
    }

    public static function fromArray(array $data): self
    {
        $root = self::parseNode($data['components'][0] ?? []);
        
        return new self(
            $data['screen'] ?? '',
            $root,
            $data['meta'] ?? []
        );
    }

    private static function parseNode(array $node): NodeInterface
    {
        $type = $node['type'] ?? '';
        
        return match($type) {
            'VStack' => new VStack(
                array_map(fn($child) => self::parseNode($child), $node['children'] ?? []),
                $node['class'] ?? '',
                $node['props'] ?? []
            ),
            'HStack' => new HStack(
                array_map(fn($child) => self::parseNode($child), $node['children'] ?? []),
                $node['class'] ?? '',
                $node['props'] ?? []
            ),
            'Text' => new Text(
                $node['value'] ?? '',
                $node['class'] ?? '',
                $node['props'] ?? []
            ),
            'Button' => new Button(
                $node['text'] ?? '',
                $node['class'] ?? '',
                $node['props'] ?? []
            ),
            'Input' => new Input(
                $node['name'] ?? '',
                $node['label'] ?? '',
                $node['inputType'] ?? $node['type'] ?? 'text',
                $node['class'] ?? '',
                $node['props'] ?? []
            ),
            'Container' => new Container(
                array_map(fn($child) => self::parseNode($child), $node['children'] ?? []),
                $node['class'] ?? '',
                $node['props'] ?? []
            ),
            default => new VStack()
        };
    }
}
