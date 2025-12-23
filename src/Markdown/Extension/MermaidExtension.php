<?php

namespace App\Markdown\Extension;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;

class MermaidExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addBlockStartParser(MermaidParser::class, 50);
        $environment->addRenderer(MermaidBlock::class, new MermaidRenderer());
    }
}
