<?php

namespace Wizbii\EditorJsToHtml\Model\Block;

use Symfony\Component\Serializer\Attribute\DiscriminatorMap;

#[DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        ParagraphBlock::TYPE => ParagraphBlock::class,
        HeaderBlock::TYPE => HeaderBlock::class,
        ListBlock::TYPE => ListBlock::class,
        ImageBlock::TYPE => ImageBlock::class,
    ]
)]
abstract class AbstractBlock implements BlockInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
    ) {
    }
}
