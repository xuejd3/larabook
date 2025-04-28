<?php

/*
 * This file is part of the Xuejd3\LaraBook.
 *
 * (c) xuejd3 <xuejd3@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Xuejd3\LaraBook\Renders;

use League\CommonMark\GithubFlavoredMarkdownConverter;
use Xuejd3\LaraBook\Contracts\Renderer;

/**
 * Class Markdown.
 */
class Markdown implements Renderer
{
    public function render(string $content): string
    {
        $config = config('larabook.markdown');

        $converter = new GithubFlavoredMarkdownConverter($config);

        // return $converter->convertToHtml(emoji($content));
        return $converter->convert(emoji($content));
    }
}
