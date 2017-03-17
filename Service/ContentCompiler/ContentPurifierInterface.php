<?php declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler;

interface ContentPurifierInterface
{
    /**
     * Clean up external content that were put by users
     * ================================================
     *   Example: Remove external links or make them rel="nofollow" and to open in new window
     *
     * @param string $input
     * @param bool $strict
     * @return string output
     */
    public function purifyExternalContent(string $input, bool $strict = false) : string;

    /**
     * Clean up all dangerous things from the input code
     *
     * @param string $input
     * @return string output
     */
    public function purify(string $input) : string;
}
