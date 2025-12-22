<?php

namespace App\Extension\Node;

use League\CommonMark\Node\Block\AbstractBlock;

class Admonition extends AbstractBlock
{
    private string $type;

    public function __construct(string $type)
    {
        parent::__construct();
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
