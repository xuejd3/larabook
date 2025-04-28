<?php

/*
 * This file is part of the Xuejd3\LaraBook.
 *
 * (c) xuejd3 <xuejd3@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Xuejd3\LaraBook\Commands;

use Illuminate\Console\Command;
use Xuejd3\LaraBook\LaraBookServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabook:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install LaraBook and publish the required files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish',
            ['--provider' => LaraBookServiceProvider::class, '--tag' => ['larabook-assets', 'larabook-config']]);

        $this->info('LaraBook successfully installed! Enjoy 😍');
    }
}
