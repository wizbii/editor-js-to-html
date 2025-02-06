<?php

namespace Wizbii\EditorJsToHtml\Model\Block;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Wizbii\EditorJsToHtml\Enum\ListStyle;

final class ListBlock extends AbstractBlock
{
    public const TYPE = 'list';

    public function __construct(
        string $id,
        #[SerializedPath('[data][style]')]
        public readonly ListStyle $style,
        /** @var string[] $items */
        #[SerializedPath('[data][items]')]
        public readonly array $items,
    ) {
        parent::__construct($id, self::TYPE);
    }

    public function render(): string
    {
        $items = implode(
            separator: "\n",
            array: array_map(
                fn (string $text): string => "<li>$text</li>",
                $this->items,
            ),
        );

        return $this->style === ListStyle::ORDERED ? "<ol>\n$items\n</ol>" : "<ul>\n$items\n</ul>";
    }
}
