<?php

declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;
use ContentCompilerBundle\Service\ContentCompiler\ContentPurifierInterface;

/**
 * MarkdownCompiler
 * ================.
 */
class MarkdownCompiler extends AbstractCompiler implements ContentCompilerInterface
{
    /**
     * @var \Parsedown
     */
    protected $parser;

    /**
     * @param ContentPurifierInterface $purifier
     */
    public function __construct(ContentPurifierInterface $purifier)
    {
        parent::__construct($purifier);
        $this->parser = new \Parsedown();
    }

    /**
     * {@inheritdoc}
     */
    public function compileFromString($string, $strict = false, array $parameters = []): string
    {
        $string = htmlspecialchars($string);

        $string = $this->parser->text($string);
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
        return 'markdown';
    }

    /**
     * {@inheritdoc}
     */
    public function wouldHandle(string $extension, string $mime): bool
    {
        $supportedMimes = [
            'text/plain',
            'text/markdown',
            'text/x-markdown',
        ];

        $supportedExtensions = [
            'md', 'txt',
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
