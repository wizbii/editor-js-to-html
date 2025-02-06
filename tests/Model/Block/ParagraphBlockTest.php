<?php

namespace Model\Block;

use PHPUnit\Framework\Attributes\CoversMethod;
use Wizbii\EditorJsToHtml\Model\Block\ParagraphBlock;
use PHPUnit\Framework\TestCase;

#[CoversMethod(ParagraphBlock::class, 'render')]
class ParagraphBlockTest extends TestCase
{
    public function testRender()
    {
        $id = uniqid('id');
        $text = uniqid('text');

        $paragraph = new ParagraphBlock(
            id: $id,
            text: $text,
        );

        $this->assertEquals("<p>$text</p>", $paragraph->render());
    }
}
