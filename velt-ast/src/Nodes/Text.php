<?php

namespace VeltAst\Nodes;

use VeltAst\NodeInterface;

class Text implements NodeInterface
{
    public function __construct(
        public string $value = '',
        public string $class = '',
        public array $props = []
    ) {}

    public function getType(): string
    {
        return 'Text';
    }

    public function toArray(): array
    {
        return [
            'type' => 'Text',
            'value' => $this->value,
            'class' => $this->class,
            'props' => $this->props
        ];
    }
}
