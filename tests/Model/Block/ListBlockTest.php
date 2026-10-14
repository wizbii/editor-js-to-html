<?php

namespace Model\Block;

use PHPUnit\Framework\Attributes\CoversMethod;
use Wizbii\EditorJsToHtml\Enum\ListStyle;
use Wizbii\EditorJsToHtml\Model\Block\ListBlock;
use Wizbii\EditorJsToHtml\Model\Block\ListBlock\ListItem;
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
            items: [new ListItem($text1), new ListItem($text2)],
        );

        $this->assertEquals(
            "<ol>\n<li>$text1</li>\n<li>$text2</li>\n</ol>",
            $orderedList->render(),
        );

        $unorderedList = new ListBlock(
            id: $id,
            style: ListStyle::UNORDERED,
            items: [new ListItem($text1), new ListItem($text2), new ListItem($text3)],
        );

        $this->assertEquals(
            "<ul>\n<li>$text1</li>\n<li>$text2</li>\n<li>$text3</li>\n</ul>",
            $unorderedList->render(),
        );
    }

    public function testRenderNestedItems()
    {
        $list = new ListBlock(
            id: uniqid('id'),
            style: ListStyle::ORDERED,
            items: [
                new ListItem('Parent', items: [
                    new ListItem('Child 1'),
                    new ListItem('Child 2', items: [new ListItem('Grandchild')]),
                ]),
                new ListItem('Sibling'),
            ],
        );

        $this->assertEquals(
            implode("\n", [
                '<ol>',
                '<li>Parent',
                '<ol>',
                '<li>Child 1</li>',
                '<li>Child 2',
                '<ol>',
                '<li>Grandchild</li>',
                '</ol></li>',
                '</ol></li>',
                '<li>Sibling</li>',
                '</ol>',
            ]),
            $list->render(),
        );
    }

    public function testRenderChecklist()
    {
        $list = new ListBlock(
            id: uniqid('id'),
            style: ListStyle::CHECKLIST,
            items: [
                new ListItem('Done', checked: true),
                new ListItem('Todo', items: [new ListItem('Sub', checked: true)]),
            ],
        );

        $this->assertEquals(
            implode("\n", [
                '<ul class="checklist">',
                '<li><input type="checkbox" disabled checked /> Done</li>',
                '<li><input type="checkbox" disabled /> Todo',
                '<ul class="checklist">',
                '<li><input type="checkbox" disabled checked /> Sub</li>',
                '</ul></li>',
                '</ul>',
            ]),
            $list->render(),
        );
    }
}
