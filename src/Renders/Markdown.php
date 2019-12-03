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
     * @var \Parsedown
     */
    protected $markdown;

    /**
     * Markdown constructor.
     *
     * @param \Parsedown $markdown
     */
    public function __construct(\Parsedown $markdown)
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
        return $this->markdown
            ->setBreaksEnabled(true) // 启用自动换行
            ->text(emoji($content));
    }
}
