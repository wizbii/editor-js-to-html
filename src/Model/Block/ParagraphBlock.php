<?php

namespace Wizbii\EditorJsToHtml\Model\Block;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final class ParagraphBlock extends AbstractBlock
{
    public const TYPE = 'paragraph';

    public function __construct(
        string $id,
        #[SerializedPath('[data][text]')]
        public readonly string $text,
    ) {
        parent::__construct($id, self::TYPE);
    }

    public function render(): string
    {
        return "<p>$this->text</p>";
    }
}
