<?php

declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Exception\SyntaxError;
use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;

/**
 * Compiles Twig templates into HTML.
 */
class TwigCompiler extends AbstractCompiler implements ContentCompilerInterface
{
    /**
     * Supported parameters:
     *   - self::INCLUDE_PATH Path where to look for templates in case a template has "include" or "extends" tags
     *   - self::CACHE_DIR Where to store the cache in the filesystem
     *   - self::VARIABLES Variables to assign.
     *
     * {@inheritdoc}
     */
    public function compileFromString($string, $strict = false, array $parameters = []): string
    {
        $loaders = [
            new \Twig_Loader_Array([
                'str' => $string,
            ]),
        ];

        if (isset($parameters[self::INCLUDE_PATH])) {
            $loaders[] = new \Twig_Loader_Filesystem($parameters[self::INCLUDE_PATH]);
        }

        $loader = new \Twig_Loader_Chain($loaders);

        $twig = new \Twig_Environment($loader, array_filter([
            'cache' => $parameters[self::CACHE_DIR] ?? null,
        ]));

        try {
            return $twig->render('str', $parameters[self::VARIABLES] ?? []);
        } catch (\Twig_Error_Syntax $e) {
            throw new SyntaxError('Syntax error while compiling from string, details: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'twig';
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
            'twig', 'j2', 'jinja2',
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
