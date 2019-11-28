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

/**
 * Class Markdown.
 */
class Markdown implements Renderer
{
    /**
     * @var \ParsedownExtra
     */
    protected $markdown;

    /**
     * Markdown constructor.
     *
     * @param \ParsedownExtra $markdown
     */
    public function __construct(\ParsedownExtra $markdown)
    {
        $this->markdown = $markdown;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function render(string $content): string
    {
        return $this->markdown->text(emoji($content));
    }
}
