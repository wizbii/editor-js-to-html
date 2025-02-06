<?php

namespace Model\Block;

use PHPUnit\Framework\Attributes\CoversMethod;
use Wizbii\EditorJsToHtml\Model\Block\HeaderBlock;
use PHPUnit\Framework\TestCase;

#[CoversMethod(HeaderBlock::class, 'render')]
class HeaderBlockTest extends TestCase
{
    public function testRender()
    {
        $id = uniqid('id');
        $text = uniqid('text');
        $level = rand(1, 5);

        $header = new HeaderBlock(
            id: $id,
            text: $text,
            level: $level,
        );

        $this->assertEquals("<h$level>$text</h$level>", $header->render());
    }
}
