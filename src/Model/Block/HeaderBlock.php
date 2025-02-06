<?php

namespace Wizbii\EditorJsToHtml\Model\Block;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final class HeaderBlock extends AbstractBlock
{
    public const TYPE = 'header';

    public function __construct(
        string $id,
        #[SerializedPath('[data][text]')]
        public readonly string $text,
        #[SerializedPath('[data][level]')]
        public readonly int $level,
    ) {
        parent::__construct($id, self::TYPE);
    }

    public function render(): string
    {
        return "<h$this->level>$this->text</h$this->level>";
    }
}
