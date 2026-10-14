<?php

namespace Wizbii\EditorJsToHtml\Model\Block;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Wizbii\EditorJsToHtml\Enum\ListStyle;
use Wizbii\EditorJsToHtml\Model\Block\ListBlock\ListItem;

final class ListBlock extends AbstractBlock
{
    public const TYPE = 'list';

    public function __construct(
        string $id,
        #[SerializedPath('[data][style]')]
        public readonly ListStyle $style,
        /** @var ListItem[] $items */
        #[SerializedPath('[data][items]')]
        public readonly array $items,
    ) {
        parent::__construct($id, self::TYPE);
    }

    public function render(): string
    {
        return $this->renderList($this->items);
    }

    /**
     * @param ListItem[] $items
     */
    private function renderList(array $items): string
    {
        $htmlItems = implode(
            separator: "\n",
            array: array_map(
                fn (ListItem $item): string => $this->renderItem($item),
                $items,
            ),
        );

        return match ($this->style) {
            ListStyle::ORDERED => "<ol>\n$htmlItems\n</ol>",
            ListStyle::UNORDERED => "<ul>\n$htmlItems\n</ul>",
            ListStyle::CHECKLIST => "<ul class=\"checklist\">\n$htmlItems\n</ul>",
        };
    }

    private function renderItem(ListItem $item): string
    {
        $content = $item->content;

        if ($this->style === ListStyle::CHECKLIST) {
            $checked = $item->checked ? ' checked' : '';
            $content = "<input type=\"checkbox\" disabled$checked /> $content";
        }

        if ([] !== $item->items) {
            $content .= "\n".$this->renderList($item->items);
        }

        return "<li>$content</li>";
    }
}
