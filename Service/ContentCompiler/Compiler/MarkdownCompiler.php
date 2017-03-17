<?php declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;
use ContentCompilerBundle\Service\ContentCompiler\ContentPurifierInterface;

/**
 * MarkdownCompiler
 * ================
 *
 * @package Wolnosciowiec\AppBundle\Service\ContentCompiler\Compiler
 */
class MarkdownCompiler extends AbstractCompiler implements ContentCompilerInterface
{
    /**
     * @var \Parsedown $parser
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
     * @inheritdoc
     */
    public function compileFromString($string, $strict = false): string
    {
        $string = htmlspecialchars($string);

        $string = $this->parser->text($string);
        $string = $this->getPurifier()->purify($string);
        $string = $this->getPurifier()->purifyExternalContent($string, $strict);

        return $string;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'markdown';
    }
}
