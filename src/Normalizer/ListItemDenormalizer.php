<?php

namespace Wizbii\EditorJsToHtml\Normalizer;

use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Wizbii\EditorJsToHtml\Model\Block\ListBlock\ListItem;

/**
 * Supports both list item formats:
 *  - legacy (@editorjs/list v1): a plain string
 *  - @editorjs/list v2: an object {content, meta, items} with optional nested items
 */
final class ListItemDenormalizer implements DenormalizerInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): ListItem
    {
        if (is_string($data)) {
            return new ListItem(content: $data);
        }

        if (!is_array($data) || !is_string($data['content'] ?? null)) {
            throw new UnexpectedValueException('A list item must be a string or an object with a "content" string.');
        }

        $meta = is_array($data['meta'] ?? null) ? $data['meta'] : [];
        $items = is_array($data['items'] ?? null) ? $data['items'] : [];

        return new ListItem(
            content: $data['content'],
            checked: true === ($meta['checked'] ?? false),
            items: array_values(array_map(
                fn (mixed $item): ListItem => $this->denormalize($item, $type, $format, $context),
                $items,
            )),
        );
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return ListItem::class === $type;
    }

    /**
     * @return array<class-string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [ListItem::class => true];
    }
}
