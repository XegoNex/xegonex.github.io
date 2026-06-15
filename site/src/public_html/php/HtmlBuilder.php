<?php

declare(strict_types=1);

final class HtmlBuilder
{
    private string $buffer = '';

    public function raw(string $content): self
    {
        $this->buffer .= $content;
        return $this;
    }

    public function tag(string $name, array $attrs = [], ?string $inner = null, bool $selfClose = false): self
    {
        $attrString = $this->buildAttributes($attrs);
        if ($selfClose) {
            $this->buffer .= "<{$name}{$attrString} />";
            return $this;
        }
        $this->buffer .= "<{$name}{$attrString}>";
        if ($inner !== null) {
            $this->buffer .= $inner;
        }
        $this->buffer .= "</{$name}>";
        return $this;
    }

    public function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public function render(): string
    {
        return $this->buffer;
    }

    private function buildAttributes(array $attrs): string
    {
        if ($attrs === []) {
            return '';
        }
        $parts = [];
        foreach ($attrs as $key => $value) {
            if ($value === null || $value === false) {
                continue;
            }
            if ($value === true) {
                $parts[] = $this->escape((string) $key);
                continue;
            }
            $parts[] = $this->escape((string) $key) . '="' . $this->escape((string) $value) . '"';
        }
        return $parts === [] ? '' : ' ' . implode(' ', $parts);
    }
}
