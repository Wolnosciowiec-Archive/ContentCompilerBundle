<?php

declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;

/**
 * HtmlCompiler
 * ================.
 */
class HtmlCompiler extends AbstractCompiler implements ContentCompilerInterface
{
    /**
     * {@inheritdoc}
     */
    public function compileFromString($string, $strict = false, array $parameters = []): string
    {
        $string = $this->getPurifier()->purify($string);

        if ($parameters[self::ESCAPE_LINKS] ?? true) {
            $string = $this->getPurifier()->purifyExternalContent($string, $strict);
        }

        return $string;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'html';
    }

    /**
     * {@inheritdoc}
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
