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

    /**
     * @inheritdoc
     */
    public function wouldHandle(string $extension = null, string $mime = null): bool
    {
        $supportedMimes = [
            'text/plain',
            'text/html',
        ];

        $supportedExtensions = [
            'html', 'htm', 'txt',
        ];

        if ($extension) {
            return in_array(strtolower($extension), $supportedExtensions, true);
        }

        if ($mime) {
            return in_array(strtolower($mime), $supportedMimes, true);
        }

        return false;
    }
}
