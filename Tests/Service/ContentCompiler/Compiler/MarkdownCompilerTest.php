<?php declare(strict_types=1);

namespace Tests\Service\ContentCompiler\Compiler;

use Tests\TestCase;

/**
 * @see MarkdownCompiler
 */
class MarkdownCompilerTest extends TestCase
{
    /**
     * @return array
     */
    public function markdownDataProvider()
    {
        return [
            [
                '**bold text**',
                '<strong>bold text</strong>'
            ],

            [
                '- this is a list item',
                '<li>this is a list item</li>'
            ],
        ];
    }

    /**
     * @dataProvider markdownDataProvider
     *
     * @param string $text
     * @param string $expectedText
     */
    public function testCompilingToMarkdown($text, $expectedText)
    {
        $result = $this
            ->container
            ->get('wolnosciowiec.contentcompiler.factory')
            ->getContentCompiler('markdown')
            ->compileFromString($text);

        $this->assertContains($expectedText, $result);
    }
}