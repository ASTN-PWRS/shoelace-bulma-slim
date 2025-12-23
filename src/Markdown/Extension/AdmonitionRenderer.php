<?php

namespace App\Markdown\Extension;

use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Node\Node;
use App\Markdown\Extension\Node\Admonition;

class AdmonitionRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Admonition)) {
            throw new \InvalidArgumentException('Expected Admonition node');
        }

        $type = $node->getType();
        $title = ucfirst($type);
        $content = $childRenderer->renderNodes($node->children());

        return <<<HTML
<div class="admonition {$type}">
  <p class="admonition-title">{$title}</p>
  {$content}
</div>
HTML;
    }
}
