<?php

namespace VeltAst\Nodes;

use VeltAst\NodeInterface;

class Container implements NodeInterface
{
    public function __construct(
        public array $children = [],
        public string $class = '',
        public array $props = []
    ) {}

    public function getType(): string
    {
        return 'Container';
    }

    public function toArray(): array
    {
        return [
            'type' => 'Container',
            'class' => $this->class,
            'props' => $this->props,
            'children' => array_map(fn($child) => $child instanceof NodeInterface ? $child->toArray() : $child, $this->children)
        ];
    }
}
