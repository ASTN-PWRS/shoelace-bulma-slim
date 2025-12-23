<?php

namespace App\Markdown;

use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\Attributes\AttributesExtension;

class MarkdownRenderer
{
    private MarkdownConverter $converter;

    /**
     * @param ExtensionInterface[] $extensions
     */
    public function __construct(array $extensions = [])
    {
        $environment = new Environment();

        // 必須の CommonMark 拡張を先に追加
        $environment->addExtension(new CommonMarkCoreExtension());

        // AttributesExtension を追加
        $environment->addExtension(new AttributesExtension());

        // 外部から渡された拡張を追加
        foreach ($extensions as $extension) {
            $environment->addExtension($extension);
        }

        $this->converter = new MarkdownConverter($environment);
    }

    public function toHtml(string $markdown): string
    {
        return $this->converter->convert($markdown)->getContent();
    }
}
