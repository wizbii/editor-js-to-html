<?php

namespace Wizbii\EditorJsToHtml\Helper;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Wizbii\EditorJsToHtml\Model\EditorJs;

class EditorJsHelper
{
    /**
     * @throws ExceptionInterface
     */
    public static function renderEditorJsToHtml(string $json): string
    {
        $editorJs = self::parseEditorJsToObject($json);

        return $editorJs->render();
    }

    /**
     * @throws ExceptionInterface
     */
    private static function parseEditorJsToObject(string $json): EditorJs
    {
        $serializer = self::createSerializer();

        return $serializer->deserialize($json, EditorJs::class, JsonEncoder::FORMAT);
    }

    private static function createSerializer(): SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $propertyTypeExtractor = new PropertyInfoExtractor([], [new PhpDocExtractor()]);
        $classDiscriminatorResolver = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);

        return new Serializer(
            [
                new ArrayDenormalizer(),
                new BackedEnumNormalizer(),
                new ObjectNormalizer(
                    classMetadataFactory: $classMetadataFactory,
                    propertyTypeExtractor: $propertyTypeExtractor,
                    classDiscriminatorResolver: $classDiscriminatorResolver,
                ),
            ],
            ['json' => new JsonEncoder()]
        );
    }
}
