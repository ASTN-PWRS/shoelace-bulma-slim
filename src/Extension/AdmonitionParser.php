<?php

namespace App\Extension;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use App\Extension\Node\Admonition;

class AdmonitionParser implements BlockStartParserInterface
{
    public function tryStart(Cursor $cursor): BlockStart
    {
        $line = $cursor->getLine();
        $match = [];

        if (preg_match('/^!!!\s*(\w+)/', $line, $match)) {
            $type = strtolower($match[1]);
            $cursor->advanceToNextNonSpace();
            return BlockStart::of(new class($type) extends \League\CommonMark\Parser\Block\AbstractBlockContinueParser {
                private Admonition $block;

                public function __construct(string $type)
                {
                    $this->block = new Admonition($type);
                }

                public function getBlock(): \League\CommonMark\Node\Block\Block
                {
                    return $this->block;
                }

                public function tryContinue(Cursor $cursor, \League\CommonMark\Parser\Block\BlockContinueParserInterface $activeBlockParser): \League\CommonMark\Parser\Block\BlockContinue
                {
                    return \League\CommonMark\Parser\Block\BlockContinue::at($cursor);
                }
            });
        }

        return BlockStart::none();
    }
}
