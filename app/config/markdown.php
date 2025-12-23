<?php
use App\Markdown\MarkdownRenderer;
use App\Markdown\Controller\MarkdownController;
use App\Markdown\Extension\AdmonitionExtension;
use App\Markdown\Extension\MermaidExtension;


use League\CommonMark\Extension\ExtensionInterface;
use function DI\autowire;
use function DI\get;

return [
  // 拡張機能をまとめた配列を定義
  'markdown.extensions' => [
    get(AdmonitionExtension::class),
    get(MermaidExtension::class),
  ],
  // MarkdownRenderer に拡張を注入
  MarkdownRenderer::class => autowire()
    ->constructorParameter('extensions', get('markdown.extensions')),
  // MarkdownController に MarkdownRenderer を自動注入
  MarkdownController::class => autowire(),
  // 拡張クラスも自動解決
  AdmonitionExtension::class => autowire(), 
  MermaidExtension::class => autowire()
];