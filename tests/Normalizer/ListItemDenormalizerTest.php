<?php

namespace Normalizer;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Wizbii\EditorJsToHtml\Model\Block\ListBlock\ListItem;
use Wizbii\EditorJsToHtml\Normalizer\ListItemDenormalizer;

#[CoversClass(ListItemDenormalizer::class)]
class ListItemDenormalizerTest extends TestCase
{
    public function testDenormalizeLegacyString()
    {
        $item = (new ListItemDenormalizer())->denormalize('Jour', ListItem::class);

        $this->assertEquals(new ListItem('Jour'), $item);
    }

    public function testDenormalizeV2Object()
    {
        $item = (new ListItemDenormalizer())->denormalize(
            [
                'content' => 'Parent',
                'meta' => [],
                'items' => [
                    ['content' => 'Child', 'meta' => ['checked' => true], 'items' => []],
                ],
            ],
            ListItem::class,
        );

        $this->assertEquals(
            new ListItem('Parent', items: [new ListItem('Child', checked: true)]),
            $item,
        );
    }

    public function testDenormalizeInvalidItem()
    {
        $this->expectException(UnexpectedValueException::class);

        (new ListItemDenormalizer())->denormalize(['meta' => []], ListItem::class);
    }
}
