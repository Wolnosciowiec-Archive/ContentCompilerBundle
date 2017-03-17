<?php declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler\Compiler;

use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;
use ContentCompilerBundle\Service\ContentCompiler\ContentPurifierInterface;

/**
 * AbstractCompiler
 *
 * @package Wolnosciowiec\AppBundle\Service\ContentCompiler
 */
abstract class AbstractCompiler implements ContentCompilerInterface
{
    /**
     * @var ContentPurifierInterface $purifier
     */
    private $purifier;

    /**
     * @param ContentPurifierInterface $purifier
     */
    public function __construct(ContentPurifierInterface $purifier)
    {
        $this->purifier = $purifier;
    }

    /**
     * @return ContentPurifierInterface
     */
    public function getPurifier(): ContentPurifierInterface
    {
        return $this->purifier;
    }
}
