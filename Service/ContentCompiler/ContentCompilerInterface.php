<?php

declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler;

interface ContentCompilerInterface
{
    const ESCAPE_LINKS = 'links_escape';
    const VARIABLES = 'vars';
    const INCLUDE_PATH = 'include_path';
    const CACHE_DIR = 'cache_dir';

    /**
     * Compile source code text
     * ========================.
     *
     * @param string $string
     * @param bool   $strict
     * @param array  $parameters
     *
     * @return string
     */
    public function compileFromString($string, $strict = false, array $parameters = []) : string;

    /**
     * @return ContentPurifierInterface
     */
    public function getPurifier() : ContentPurifierInterface;

    /**
     * Identify self.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Ask the implementation if it can handle specific type of file.
     *
     * @param string $extension
     * @param string $mime
     *
     * @return bool
     */
    public function wouldHandle(string $extension, string $mime): bool;
}
