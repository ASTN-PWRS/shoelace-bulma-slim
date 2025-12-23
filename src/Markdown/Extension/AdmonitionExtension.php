<?php

namespace App\Markdown\Extension;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use App\Extension\AdmonitionParser;
use App\Extension\AdmonitionRenderer;
use App\Extension\Node\Admonition;

class AdmonitionExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addBlockStartParser(new AdmonitionParser(), 50);
        $environment->addRenderer(Admonition::class, new AdmonitionRenderer());
    }
}
