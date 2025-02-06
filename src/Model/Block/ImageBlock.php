<?php

namespace Wizbii\EditorJsToHtml\Model\Block;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final class ImageBlock extends AbstractBlock
{
    public const TYPE = 'image';

    public function __construct(
        string $id,
        #[SerializedPath('[data][caption]')]
        public readonly string $caption,
        #[SerializedPath('[data][withBorder]')]
        public readonly bool $withBorder,
        #[SerializedPath('[data][withBackground]')]
        public readonly bool $withBackground,
        #[SerializedPath('[data][stretched]')]
        public readonly bool $stretched,
        #[SerializedPath('[data][file][url]')]
        public readonly string $fileUrl,
    ) {
        parent::__construct($id, self::TYPE);
    }

    public function render(): string
    {
        $classNames = array_filter([
            $this->withBorder ? 'withBorder' : '',
            $this->withBackground ? 'withBackground' : '',
            $this->stretched ? 'stretched' : '',
        ]);

        return sprintf(
            '<img src="%s" alt="%s" class="%s" />',
            $this->fileUrl,
            $this->caption,
            implode(' ', $classNames),
        );
    }
}
