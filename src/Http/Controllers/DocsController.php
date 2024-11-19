<?php

/*
 * This file is part of the Xuejd3\LaraBook.
 *
 * (c) xuejd3 <xuejd3@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Xuejd3\LaraBook\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Xuejd3\LaraBook\Documentation;
use Xuejd3\LaraBook\Exceptions\PageNotFoundException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DocsController.
 */
class DocsController
{
    use AuthorizesRequests;
    /**
     * @var \Xuejd3\LaraBook\Documentation
     */
    protected $docs;

    /**
     * DocsController constructor.
     *
     * @param \Xuejd3\LaraBook\Documentation $docs
     */
    public function __construct(Documentation $docs)
    {
        $this->docs = $docs;
    }

    public function index()
    {
        return $this->show(
            config('larabook.docs.default_version'),
            \str_replace('.md', '', config('larabook.docs.home'))
        );
    }

    public function show($version, $page = null)
    {
        $page = $page ?? \config('larabook.docs.index');

        if (Gate::has('larabook.view')) {
            $this->authorize('larabook.view', [$page, $version]);
        }

        if (! file_exists($this->docs->path($version, $page))) {
            $error['title'] = 'Page Not Found.';
            $error['page'] = $page;
            $error['canonical'] = sprintf('%/%s/%s', config('larabook.docs.path'),
                config('larabook.docs.default_version'), $page);
            $error['currentVersion'] = $version;
            $error['versions'] = config('larabook.docs.versions');
            $error['fullUrl'] = \sprintf('%s/%s/%s', \config('larabook.route'), $version, $page);

            return \response(\view('larabook::errors.404', $error), 404);
        }

        $updatedAt = Carbon::parse(date('c', filemtime($this->docs->path($version, $page))))
            ->setTimezone(config('larabook.date.timezone', 'UTC'))
            ->diffForHumans();

        $data = [
            'page'           => $page,
            'title'          => null,
            'currentVersion' => $version,
            'index'          => $this->docs->index($version),
            'versions'       => config('larabook.docs.versions'),
            'updatedAt'      => $updatedAt,
            'fullUrl'        => \sprintf('%s/%s/%s', \config('larabook.route'), $version, $page),
            'editUrl'        => \sprintf('%s/edit/%s/%s.md', \config('larabook.docs.repository.url'), $version, $page),
            'canonical'      => sprintf('%/%s/%s', config('larabook.docs.path'),
                config('larabook.docs.default_version'), $page),
        ];

        try {
            $content = new Crawler($this->docs->get($version, $page));
        } catch (PageNotFoundException $e) {
            $data['title'] = 'Page Not Found.';

            return \response(\view('larabook::errors.404', $data), 404);
        }

        $titleNode = $content->filter('h1')->getNode(0);

        if ($titleNode) {
            $titleNode->parentNode->removeChild($titleNode);
            $data['title'] = $titleNode->textContent;
        }

        $data['content'] = $content->html();

        return view('larabook::docs', $data);
    }
}
