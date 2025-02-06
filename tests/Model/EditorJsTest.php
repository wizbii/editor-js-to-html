<?php

namespace Model;

use PHPUnit\Framework\Attributes\CoversMethod;
use Wizbii\EditorJsToHtml\Model\Block\AbstractBlock;
use Wizbii\EditorJsToHtml\Model\EditorJs;
use PHPUnit\Framework\TestCase;


#[CoversMethod(EditorJs::class, 'render')]
class EditorJsTest extends TestCase
{
    public function testRender()
    {
        $time = rand(1, 99999);
        $version = uniqid('version');

        $expectedBlock1Html = uniqid('block1');
        $block1 = $this->createMock(AbstractBlock::class);
        $block1
            ->expects($this->exactly(2))
            ->method('render')
            ->willReturn($expectedBlock1Html);

        $expectedBlock2Html = uniqid('block2');
        $block2 = $this->createMock(AbstractBlock::class);
        $block2
            ->expects($this->once())
            ->method('render')
            ->willReturn($expectedBlock2Html);

        $editorWithOneBlock = new EditorJs(
            time: $time,
            blocks: [$block1],
            version: $version,
        );

        $editorWithTwoBlock = new EditorJs(
            time: $time,
            blocks: [$block1, $block2],
            version: $version,
        );

        $this->assertEquals("$expectedBlock1Html", $editorWithOneBlock->render());
        $this->assertEquals("$expectedBlock1Html\n$expectedBlock2Html", $editorWithTwoBlock->render());
    }
}
