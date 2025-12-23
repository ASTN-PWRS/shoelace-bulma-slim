<?php

namespace App\Markdown\Extension\Node;

use League\CommonMark\Node\Block\AbstractBlock;

class MermaidBlock extends AbstractBlock
{
    private string $content = '';

    public function appendContent(string $line): void
    {
        $this->content .= $line . "\n";
    }

    public function getContent(): string
    {
        return trim($this->content);
    }
}
