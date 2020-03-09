<?php

/*
 * This file is part of the Xuejd3\LaraBook.
 *
 * (c) xuejd3 <xuejd3@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Xuejd3\LaraBook\Renders;

use Xuejd3\LaraBook\Contracts\Renderer;
use League\CommonMark\GithubFlavoredMarkdownConverter;

/**
 * Class Markdown.
 */
class Markdown implements Renderer
{
    /**
     * @param string $content
     *
     * @return string
     */
    public function render(string $content): string
    {
        $config = config('larabook.markdown');

        $converter = new GithubFlavoredMarkdownConverter($config);

        return $converter->convertToHtml(emoji($content));
    }
}
