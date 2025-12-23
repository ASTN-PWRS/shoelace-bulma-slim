<?php

namespace App\Markdown\Extension;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

class MermaidRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof MermaidBlock)) {
            throw new \InvalidArgumentException('Expected MermaidBlock');
        }

        $content = htmlspecialchars($node->getContent(), ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8');
        return "<div class=\"mermaid\">\n{$content}\n</div>";
    }
}
