<?php

namespace Wizbii\EditorJsToHtml\Model;

use Wizbii\EditorJsToHtml\Model\Block\AbstractBlock;

class EditorJs
{
    public function __construct(
        public int $time,
        /** @var AbstractBlock[] $blocks */
        public array $blocks,
        public string $version,
    ) {
    }

    public function render(): string
    {
        $htmlBlocs = array_map(
            fn (AbstractBlock $block): string => $block->render(),
            $this->blocks,
        );

        return implode("\n", $htmlBlocs);
    }
}
