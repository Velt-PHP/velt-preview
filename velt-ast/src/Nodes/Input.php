<?php

namespace VeltAst\Nodes;

use VeltAst\NodeInterface;

class Input implements NodeInterface
{
    public function __construct(
        public string $name = '',
        public string $label = '',
        public string $type = 'text',
        public string $class = '',
        public array $props = []
    ) {}

    public function getType(): string
    {
        return 'Input';
    }

    public function toArray(): array
    {
        return [
            'type' => 'Input',
            'name' => $this->name,
            'label' => $this->label,
            'inputType' => $this->type,
            'class' => $this->class,
            'props' => $this->props
        ];
    }
}
