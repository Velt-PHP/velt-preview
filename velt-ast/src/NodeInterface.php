<?php

namespace VeltAst;

interface NodeInterface
{
    public function toArray(): array;
    public function getType(): string;
}
