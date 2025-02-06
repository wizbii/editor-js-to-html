<?php

namespace Model\Block;

use PHPUnit\Framework\Attributes\CoversMethod;
use Wizbii\EditorJsToHtml\Model\Block\ImageBlock;
use PHPUnit\Framework\TestCase;

#[CoversMethod(ImageBlock::class, 'render')]
class ImageBlockTest extends TestCase
{
    public function testRender()
    {
        $id = uniqid('id');
        $caption = uniqid('caption');
        $fileUrl = uniqid('caption');

        $imageWithoutSubClass = new ImageBlock(
            id: $id,
            caption: $caption,
            withBorder: false,
            withBackground: false,
            stretched: false,
            fileUrl: $fileUrl,
        );

        $imageWithBorder = new ImageBlock(
            id: $id,
            caption: $caption,
            withBorder: true,
            withBackground: false,
            stretched: false,
            fileUrl: $fileUrl,
        );

        $imageWithBackground = new ImageBlock(
            id: $id,
            caption: $caption,
            withBorder: false,
            withBackground: true,
            stretched: false,
            fileUrl: $fileUrl,
        );

        $imageStretched = new ImageBlock(
            id: $id,
            caption: $caption,
            withBorder: false,
            withBackground: false,
            stretched: true,
            fileUrl: $fileUrl,
        );

        $imageWithAllSubClass = new ImageBlock(
            id: $id,
            caption: $caption,
            withBorder: true,
            withBackground: true,
            stretched: true,
            fileUrl: $fileUrl,
        );

        $this->assertEquals(
            "<img src=\"$fileUrl\" alt=\"$caption\" class=\"\" />",
            $imageWithoutSubClass->render(),
        );
        $this->assertEquals(
            "<img src=\"$fileUrl\" alt=\"$caption\" class=\"withBorder\" />",
            $imageWithBorder->render(),
        );
        $this->assertEquals(
            "<img src=\"$fileUrl\" alt=\"$caption\" class=\"withBackground\" />",
            $imageWithBackground->render(),
        );
        $this->assertEquals(
            "<img src=\"$fileUrl\" alt=\"$caption\" class=\"stretched\" />",
            $imageStretched->render(),
        );
        $this->assertEquals(
            "<img src=\"$fileUrl\" alt=\"$caption\" class=\"withBorder withBackground stretched\" />",
            $imageWithAllSubClass->render(),
        );
    }
}
