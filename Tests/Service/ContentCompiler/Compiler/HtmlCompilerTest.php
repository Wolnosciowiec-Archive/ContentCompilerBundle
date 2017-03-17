<?php declare(strict_types=1);

namespace Tests\Service\ContentCompiler\Compiler;

use Tests\TestCase;

/**
 * HtmlCompilerTest
 * ====================
 *
 * @see HtmlCompiler
 */
class HtmlCompilerTest extends TestCase
{
    /**
     * @return array
     */
    public function htmlDataProvider()
    {
        return [
            [
                '**not a markdown**',
                '**not a markdown**'
            ],

            [
                '<strong>this is not escaped</strong>',
                '<strong>this is not escaped</strong>'
            ],

            [
                '"text in quotes"',
                '"text in quotes"',
            ]
        ];
    }

    /**
     * @dataProvider htmlDataProvider
     *
     * @param string $text
     * @param string $expectedText
     */
    public function testCompilingToHtml($text, $expectedText)
    {
        $result = $this
            ->container
            ->get('wolnosciowiec.contentcompiler.factory')
            ->getContentCompiler('html')
            ->compileFromString($text);

        $this->assertContains($expectedText, $result);
    }
}
