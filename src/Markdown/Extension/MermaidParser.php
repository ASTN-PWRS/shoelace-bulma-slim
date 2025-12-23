<?php


namespace App\Markdown\Extension;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Block\BlockParserInterface;
use League\CommonMark\Parser\Cursor;

class MermaidParser implements BlockParserInterface
{
    private MermaidBlock $block;

    public function __construct()
    {
        $this->block = new MermaidBlock();
    }

    public static function tryStart(Cursor $cursor): ?BlockStart
    {
        if ($cursor->match('/^```mermaid\s*$/')) {
            return BlockStart::of(new self())->at($cursor);
        }

        return BlockStart::none();
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        if ($cursor->match('/^```$/')) {
            return BlockContinue::finished();
        }

        return BlockContinue::at($cursor);
    }

    public function addLine(string $line): void
    {
        $this->block->appendContent($line);
    }

    public function getBlock(): MermaidBlock
    {
        return $this->block;
    }

    public function isContainer(): bool
    {
        return false;
    }

    public function canContain(AbstractBlock $block): bool
    {
        return false;
    }

    public function isCode(): bool
    {
        return false;
    }
}
