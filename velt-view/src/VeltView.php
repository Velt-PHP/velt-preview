<?php

namespace VeltView;

use VeltParser\VeltParser;
use VeltAst\AST;

class VeltView
{
    private static ?VeltParser $parser = null;
    private static string $templatesPath = '';

    public static function setTemplatesPath(string $path): void
    {
        self::$templatesPath = rtrim($path, DIRECTORY_SEPARATOR);
    }

    public static function setParser(?VeltParser $parser): void
    {
        self::$parser = $parser;
    }

    public static function fromSession(string $view): self
    {
        $templatePath = self::$templatesPath . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, $view) . '.velt';
        
        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template not found: $templatePath");
        }

        $content = file_get_contents($templatePath);
        if ($content === false) {
            throw new \RuntimeException("Failed to read template: $templatePath");
        }

        $parser = self::$parser ?? new VeltParser();
        $ast = $parser->parse($content, $view);

        return new self($ast);
    }

    public function __construct(
        private AST $ast
    ) {}

    public function toJson(): string
    {
        $data = $this->ast->toArray();
        $data['schemaVersion'] = '1.0';
        
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        if ($json === false) {
            throw new \RuntimeException('Failed to encode AST to JSON');
        }

        return $json;
    }

    public function toArray(): array
    {
        $data = $this->ast->toArray();
        $data['schemaVersion'] = '1.0';
        return $data;
    }

    public function getAst(): AST
    {
        return $this->ast;
    }
}
