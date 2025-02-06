<?php

namespace Model\Block;

use PHPUnit\Framework\Attributes\CoversMethod;
use Wizbii\EditorJsToHtml\Enum\ListStyle;
use Wizbii\EditorJsToHtml\Model\Block\ListBlock;
use PHPUnit\Framework\TestCase;

#[CoversMethod(ListBlock::class, 'render')]
class ListBlockTest extends TestCase
{
    public function testRender()
    {
        $id = uniqid('id');
        $text1 = uniqid('text1');
        $text2 = uniqid('text2');
        $text3 = uniqid('text2');

        $orderedList = new ListBlock(
            id: $id,
            style: ListStyle::ORDERED,
            items: [$text1, $text2],
        );

        $this->assertEquals(
            "<ol>\n<li>$text1</li>\n<li>$text2</li>\n</ol>",
            $orderedList->render(),
        );

        $unorderedList = new ListBlock(
            id: $id,
            style: ListStyle::UNORDERED,
            items: [$text1, $text2, $text3],
        );

        $this->assertEquals(
            "<ul>\n<li>$text1</li>\n<li>$text2</li>\n<li>$text3</li>\n</ul>",
            $unorderedList->render(),
        );
    }
}
