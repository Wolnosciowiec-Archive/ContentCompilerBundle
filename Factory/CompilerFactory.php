<?php declare(strict_types=1);

namespace ContentCompilerBundle\Factory;

use ContentCompilerBundle\Exception\CompilerNotFoundException;
use ContentCompilerBundle\Service\ContentCompiler\ContentCompilerInterface;
use ContentCompilerBundle\Service\ContentCompiler\ContentPurifierInterface;

class CompilerFactory
{
    /**
     * @var ContentCompilerInterface[] $_compilers
     */
    private $_compilers = [];

    /**
     * @var ContentPurifierInterface $contentPurifier
     */
    private $contentPurifier;

    /**
     * @param ContentPurifierInterface $purifier
     */
    public function __construct(ContentPurifierInterface $purifier)
    {
        $this->contentPurifier = $purifier;
    }

    /**
     * Used by DI container to inject implementations
     *
     * @param ContentCompilerInterface $compiler
     * @return CompilerFactory
     */
    public function addCompiler(ContentCompilerInterface $compiler): CompilerFactory
    {
        $this->_compilers[$this->normalizeName($compiler->getName())] = $compiler;
        return $this;
    }

    /**
     * @param string $name
     *
     * @throws CompilerNotFoundException
     * @return ContentCompilerInterface
     */
    public function getContentCompiler($name)
    {
        $name = $this->normalizeName($name);

        if (!isset($this->_compilers[$name])) {
            throw new CompilerNotFoundException('"' . $name . '" implementation of ContentCompilerInterface not found');
        }

        return $this->_compilers[$name];
    }

    /**
     * @param string $extension
     * @param string $mimeType
     *
     * @return ContentCompilerInterface|null
     */
    public function getCompilerThatHandles(string $extension, string $mimeType)
    {
        foreach ($this->_compilers as $compiler) {
            if ($compiler->wouldHandle($extension, $mimeType)) {
                return $compiler;
            }
        }

        return null;
    }

    private function normalizeName(string $name)
    {
        return strtolower($name);
    }
}
