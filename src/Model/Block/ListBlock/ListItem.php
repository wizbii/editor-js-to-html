<?php

namespace Wizbii\EditorJsToHtml\Model\Block\ListBlock;

final class ListItem
{
    public function __construct(
        public readonly string $content,
        public readonly bool $checked = false,
        /** @var ListItem[] $items */
        public readonly array $items = [],
    ) {
    }
}
