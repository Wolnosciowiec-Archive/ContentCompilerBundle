<?php declare(strict_types=1);

namespace Tests\Factory;

use ContentCompilerBundle\Factory\CompilerFactory;
use ContentCompilerBundle\Service\ContentCompiler\Compiler\HtmlCompiler;
use ContentCompilerBundle\Service\ContentCompiler\Compiler\MarkdownCompiler;
use Tests\TestCase;

/**
 * @see CompilerFactory
 */
class CompilerFactoryTest extends TestCase
{
    public function provideDifferentTypes()
    {
        return [
            'markdown #1' => [
                'md',
                'text/plain',
                MarkdownCompiler::class,
            ],

            'markdown #2' => [
                '', // without extension
                'text/markdown',
                MarkdownCompiler::class,
            ],

            'html (mime only)' => [
                '',
                'text/html',
                HtmlCompiler::class,
            ],

            'html (extension only)' => [
                'html',
                '',
                HtmlCompiler::class,
            ],

            'html (with mime and extension)' => [
                'html',
                'text/html',
                HtmlCompiler::class,
            ],

            'unknown type file' => [
                'test123',
                'aaa',
                null,
            ],
        ];
    }

    /**
     * @return CompilerFactory
     */
    private function getFactory()
    {
        return $this->container->get('wolnosciowiec.contentcompiler.factory');
    }

    /**
     * @dataProvider provideDifferentTypes()
     *
     * @param string $extension
     * @param string $mime
     * @param string $expectedClassName
     */
    public function testGetCompilerThatHandles(string $extension, string $mime, string $expectedClassName = null)
    {
        $compiler = $this->getFactory()->getCompilerThatHandles($extension, $mime);
        $compilerName = is_object($compiler) ? get_class($compiler) : null;

        $this->assertSame($expectedClassName, $compilerName);
    }
}