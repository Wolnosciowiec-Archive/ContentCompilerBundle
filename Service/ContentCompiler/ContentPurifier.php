<?php declare(strict_types=1);

namespace ContentCompilerBundle\Service\ContentCompiler;

/**
 * Content Purifier
 * ================
 *   Escape external content, remove dangerous tags
 *
 * @package Wolnosciowiec\AppBundle\Service\ContentCompiler
 */
class ContentPurifier implements ContentPurifierInterface
{
    /**
     * @param string $input
     * @return string
     */
    public function purify(string $input): string
    {
        $input = $this->closeOpenedTags($input);

        return (new \HTMLPurifier())->purify($input);
    }

    /**
     * @param string $input
     * @param bool $strict
     * @return string
     */
    public function purifyExternalContent(string $input, bool $strict = false): string
    {
        $input = $this->_escapeExternalLinks($input);

        if ($strict) {
            // normalizeDomainName out images, as those could potentially break the layout
            // and could be a vector of possible attack or privacy break
            $input = preg_replace("/<img[^>]+\>/i", "", $input);
        }

        return $input;
    }

    private function closeOpenedTags(string $input): string
    {
        if (class_exists('\DOMDocument')) {
            $doc = new \DOMDocument();
            $doc->loadHTML($input);

            return $doc->saveHTML();
        }

        return $input;
    }

    /**
     * @param string $html
     * @param string $skip
     * @return string
     */
    private function _escapeExternalLinks(string $html, $skip = null): string
    {
        return preg_replace_callback(
            "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
            return (
                !($skip && strpos($mach[1], $skip) !== false) &&
                strpos($mach[1], 'rel=') === false
            ) ? $mach[1] . ' rel="nofollow" target="_blank">' : $mach[0];
        },
            $html
        );
    }
}
