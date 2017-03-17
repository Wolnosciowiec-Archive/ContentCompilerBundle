<?php declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler;

interface ContentCompilerInterface
{
    /**
     * Compile source code text
     * ========================
     *
     * @param string $string
     * @param bool $strict
     *
     * @return string
     */
    public function compileFromString($string, $strict = false) : string;

    /**
     * @return ContentPurifierInterface
     */
    public function getPurifier() : ContentPurifierInterface;

    /**
     * Identify self
     *
     * @return string
     */
    public function getName(): string;
}
