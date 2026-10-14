<?php

namespace Helper;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Wizbii\EditorJsToHtml\Helper\EditorJsHelper;

#[CoversMethod(EditorJsHelper::class, 'renderEditorJsToHtml')]
class EditorJsHelperTest extends TestCase
{
    public function testParseAndRenderEditorJs()
    {
        $json = '{
            "time" : 1724416790049,
            "blocks" : [
                {
                    "id" : "I0aXLNrk3g",
                    "type": "header",
                    "data": {
                        "text": "Question n°1",
                        "level": 1
                    }
                },
                {
                    "id" : "I0aXsL7VIq",
                    "type" : "paragraph",
                    "data" : {
                        "text" : "Veuillez indiquer votre date de naissance."
                    }
                },
                {
                    "id" : "6N5gPfrk3g",
                    "type" : "paragraph",
                    "data" : {
                        "text" : "<i>Cette date correspond à la date où&nbsp;<b>vous avez vu le jour</b>&nbsp;<u>pour la première fois</u>.</i>"
                    }
                },
                {
                    "id" : "j32LNViJh7",
                    "type" : "list",
                    "data" : {
                        "style" : "unordered",
                        "items" : [
                            "Jour",
                            "Mois",
                            "Année"
                        ]
                    }
                },
                {
                    "id" : "tFmRFfFrE4",
                    "type" : "image",
                    "data" : {
                        "caption" : "",
                        "withBorder" : false,
                        "withBackground" : false,
                        "stretched" : true,
                        "file" : {
                            "url" : "https://storage.googleapis.com/wizbii-files-qa3/bd464ad2-6905-440d-a196-4f2065f63031.jpg"
                        }
                    }
                }
            ],
            "version" : "2.29.1"
        }';

        $expectedHtml = [
            '<h1>Question n°1</h1>',
            '<p>Veuillez indiquer votre date de naissance.</p>',
            '<p><i>Cette date correspond à la date où&nbsp;<b>vous avez vu le jour</b>&nbsp;<u>pour la première fois</u>.</i></p>',
            '<ul>',
            '<li>Jour</li>',
            '<li>Mois</li>',
            '<li>Année</li>',
            '</ul>',
            '<img src="https://storage.googleapis.com/wizbii-files-qa3/bd464ad2-6905-440d-a196-4f2065f63031.jpg" alt="" class="stretched" />',
        ];

        $this->assertEquals(
            implode("\n", $expectedHtml),
            EditorJsHelper::renderEditorJsToHtml($json)
        );
    }
    public function testParseAndRenderEditorJsWithListV2()
    {
        $json = '{
            "time" : 1724416790049,
            "blocks" : [
                {
                    "id" : "j32LNViJh7",
                    "type" : "list",
                    "data" : {
                        "style" : "unordered",
                        "meta" : {},
                        "items" : [
                            {
                                "content" : "Pièce d\'identité",
                                "meta" : {},
                                "items" : [
                                    { "content" : "Carte d\'identité", "meta" : {}, "items" : [] },
                                    { "content" : "Passeport", "meta" : {}, "items" : [] }
                                ]
                            },
                            { "content" : "Justificatif de domicile", "meta" : {}, "items" : [] }
                        ]
                    }
                },
                {
                    "id" : "k43MOWjKi8",
                    "type" : "list",
                    "data" : {
                        "style" : "checklist",
                        "meta" : {},
                        "items" : [
                            { "content" : "Avoir moins de 26 ans", "meta" : { "checked" : true }, "items" : [] },
                            { "content" : "Être étudiant", "meta" : { "checked" : false }, "items" : [] }
                        ]
                    }
                }
            ],
            "version" : "2.30.7"
        }';

        $expectedHtml = [
            '<ul>',
            '<li>Pièce d\'identité',
            '<ul>',
            '<li>Carte d\'identité</li>',
            '<li>Passeport</li>',
            '</ul></li>',
            '<li>Justificatif de domicile</li>',
            '</ul>',
            '<ul class="checklist">',
            '<li><input type="checkbox" disabled checked /> Avoir moins de 26 ans</li>',
            '<li><input type="checkbox" disabled /> Être étudiant</li>',
            '</ul>',
        ];

        $this->assertEquals(
            implode("\n", $expectedHtml),
            EditorJsHelper::renderEditorJsToHtml($json)
        );
    }
    public function testParseAndRenderEditorJsWithInvalidJson()
    {
        $invalidJson = 'invalid json';

        $this->expectException(ExceptionInterface::class);

        EditorJsHelper::renderEditorJsToHtml($invalidJson);
    }
    public function testParseAndRenderEditorJsWithPartialJson()
    {
        $partialJson = '{
            "time" : 1724416790049,
            "version" : "2.29.1"
        }';

        $this->expectException(ExceptionInterface::class);

        EditorJsHelper::renderEditorJsToHtml($partialJson);
    }
}
