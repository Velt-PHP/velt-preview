<?php

namespace VeltAst\Nodes;

use VeltAst\NodeInterface;

class HStack implements NodeInterface
{
    public function __construct(
        public array $children = [],
        public string $class = '',
        public array $props = []
    ) {}

    public function getType(): string
    {
        return 'HStack';
    }

    public function toArray(): array
    {
        return [
            'type' => 'HStack',
            'class' => $this->class,
            'props' => $this->props,
            'children' => array_map(fn($child) => $child instanceof NodeInterface ? $child->toArray() : $child, $this->children)
        ];
    }
}
