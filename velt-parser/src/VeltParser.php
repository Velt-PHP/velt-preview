<?php

namespace VeltParser;

use VeltAst\AST;
use VeltAst\Nodes\VStack;
use VeltAst\Nodes\HStack;
use VeltAst\Nodes\Text;
use VeltAst\Nodes\Button;
use VeltAst\Nodes\Input;
use VeltAst\Nodes\Container;

class VeltParser
{
    private array $tokens = [];
    private int $position = 0;

    public function parse(string $content, string $view): AST
    {
        $this->tokens = $this->tokenize($content);
        $this->position = 0;

        $root = $this->parseComponent();

        return new AST($view, $root, ['source' => $view]);
    }

    private function tokenize(string $content): array
    {
        $tokens = [];
        $lines = explode("\n", $content);
        
        foreach ($lines as $line) {
            if ($line === '' || trim($line) === '' || str_starts_with(trim($line), '//')) {
                continue;
            }
            // Keep original line with indentation
            $tokens[] = $line;
        }

        return $tokens;
    }

    private function parseComponent(): ?object
    {
        if ($this->position >= count($this->tokens)) {
            return null;
        }

        $token = $this->tokens[$this->position];
        $this->position++;

        // Parse indentation level
        $indent = strlen($token) - strlen(ltrim($token));
        $token = trim($token);

        // Parse component type and props
        if (preg_match('/^(\w+)(?:\s+(.+))?$/', $token, $matches)) {
            $type = $matches[1];
            $propsString = $matches[2] ?? '';

            $props = $this->parseProps($propsString);
            $children = [];

            // Parse children (next lines with greater indentation)
            while ($this->position < count($this->tokens)) {
                $nextToken = $this->tokens[$this->position];
                $nextIndent = strlen($nextToken) - strlen(ltrim($nextToken));
                
                if ($nextIndent <= $indent) {
                    break;
                }

                $child = $this->parseComponent();
                if ($child !== null) {
                    $children[] = $child;
                }
            }

            return $this->createNode($type, $props, $children);
        }

        return null;
    }

    private function parseProps(string $propsString): array
    {
        $props = [];
        
        if ($propsString === '') {
            return $props;
        }

        // Parse props like: class="flex-1" text="Hello"
        preg_match_all('/(\w+)="([^"]*)"/', $propsString, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $props[$match[1]] = $match[2];
        }

        return $props;
    }

    private function createNode(string $type, array $props, array $children): object
    {
        return match($type) {
            'VStack' => new VStack($children, $props['class'] ?? '', $props),
            'HStack' => new HStack($children, $props['class'] ?? '', $props),
            'Text' => new Text($props['value'] ?? '', $props['class'] ?? '', $props),
            'Button' => new Button($props['text'] ?? '', $props['class'] ?? '', $props),
            'Input' => new Input(
                $props['name'] ?? '',
                $props['label'] ?? '',
                $props['type'] ?? 'text',
                $props['class'] ?? '',
                $props
            ),
            'Container' => new Container($children, $props['class'] ?? '', $props),
            default => new VStack($children, '', $props)
        };
    }
}
