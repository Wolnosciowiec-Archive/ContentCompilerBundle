<?php declare(strict_types=1);

namespace Tests\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;
use Tests\TestCase;

/**
 * @see TwigCompiler
 */
class TwigCompilerTest extends TestCase
{
    /**
     * @return array
     */
    public function provideExamples()
    {
        return [
            'with variable' => [
                [
                    'text' => 'bold text',
                ],
                '<strong>{{ text }}</strong>',
                '<strong>bold text</strong>',
            ],

            'without tags' => [
                [],
                '- this is a list item',
                '- this is a list item',
            ],
        ];
    }

    /**
     * @dataProvider provideExamples
     *
     * @param string $text
     * @param string $expectedText
     */
    public function testCompilingFromTwig($variables, $text, $expectedText)
    {
        $result = $this
            ->container
            ->get('wolnosciowiec.contentcompiler.factory')
            ->getContentCompiler('twig')
            ->compileFromString($text, false, [
                ContentCompilerInterface::VARIABLES => $variables
            ]);

        $this->assertContains($expectedText, $result);
    }

    /**
     * @expectedException \ContentCompilerBundle\Exception\SyntaxError
     */
    public function testSyntaxError()
    {
        $this
            ->container
            ->get('wolnosciowiec.contentcompiler.factory')
            ->getContentCompiler('twig')
            ->compileFromString('{{ %}');
    }
}
