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
interface BlockInterface
{
    public function render(): string;
}
