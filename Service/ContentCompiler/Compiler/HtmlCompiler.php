<?php declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;

/**
 * HtmlCompiler
 * ================
 *
 * @package Wolnosciowiec\AppBundle\Service\ContentCompiler\Compiler
 */
class HtmlCompiler extends AbstractCompiler implements ContentCompilerInterface
{
    /**
     * @inheritdoc
     */
    public function compileFromString($string, $strict = false): string
    {
        $string = $this->getPurifier()->purify($string);
        $string = $this->getPurifier()->purifyExternalContent($string);

        return $string;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'html';
    }
}
