<?php

/*
 * This file is part of the Xuejd3\LaraBook.
 *
 * (c) xuejd3 <xuejd3@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Xuejd3\LaraBook;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use Xuejd3\LaraBook\Contracts\Renderer;
use Xuejd3\LaraBook\Exceptions\PageNotFoundException;

/**
 * Class Documentation.
 */
class Documentation
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Xuejd3\LaraBook\Contracts\Render
     */
    protected $renderer;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Documentation constructor.
     */
    public function __construct(Filesystem $filesystem, Renderer $renderer, Cache $cache)
    {
        $this->filesystem = $filesystem;
        $this->renderer = $renderer;
        $this->cache = $cache;
    }

    /**
     * @return array|null
     */
    public function index(string $version)
    {
        return $this->cache->remember(
            \sprintf('docs.%s.index', $version ?? config('larabook.docs.default_version')),
            \config('larabook.cache.ttl'),
            function () use ($version) {
                $homepage = \config('larabook.docs.index', \config('larabook.docs.home', 'README.md'));

                if ($this->has($version, $homepage)) {
                    return $this->replaceLinks($version,
                        (new Crawler($this->get($version, $homepage)))->filter('ul')->html(''));
                }

                return null;
            });
    }

    public function get(string $version, string $page)
    {
        if (! $this->has($version, $page)) {
            throw new PageNotFoundException(\sprintf("Page '%s' of version '%s' not found.", $page, $version));
        }

        return $this->renderer->render($this->content($version, $page));
    }

    public function has(string $version, string $page)
    {
        return $this->filesystem->exists($this->path($version, $page));
    }

    /**
     * @return string
     */
    public function path(string $version, string $page)
    {
        return \sprintf('%s/%s/%s', \base_path(config('larabook.docs.path')), $version, Str::finish($page, '.md'));
    }

    /**
     * @return resource|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function content(string $version, string $page)
    {
        if (! $this->has($version, $page)) {
            throw new PageNotFoundException(\sprintf("Page '%s' of version '%s' not found.", $page, $version));
        }

        return $this->cache->remember(
            \sprintf('docs.%s.%s', $version, $page),
            config('larabook.cache.ttl'),
            function () use ($version, $page) {
                return $this->filesystem->get($this->path($version, $page));
            });
    }

    /**
     * @return mixed
     */
    public function replaceLinks(string $version, string $content)
    {
        return str_replace(\urlencode('{{version}}'), $version, $content);
    }
}
