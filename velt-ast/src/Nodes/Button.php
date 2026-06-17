<?php

namespace VeltAst\Nodes;

use VeltAst\NodeInterface;

class Button implements NodeInterface
{
    public function __construct(
        public string $text = '',
        public string $class = '',
        public array $props = []
    ) {}

    public function getType(): string
    {
        return 'Button';
    }

    public function toArray(): array
    {
        return [
            'type' => 'Button',
            'text' => $this->text,
            'class' => $this->class,
            'props' => $this->props
        ];
    }
}
