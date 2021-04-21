<?php

declare(strict_types=1);

/**
 * This file is part of Laravel Console Summary.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\LaravelConsoleSummary;

use Illuminate\Support\ServiceProvider;
use NunoMaduro\LaravelConsoleSummary\Contracts\DescriberContract;

/**
 * This is an Laravel Console Summary Service Provider implementation.
 */
class LaravelConsoleSummaryServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-console-summary.php'),
        ], 'config');

        $this->commands(SummaryCommand::class);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-console-summary');
        $this->app->singleton(DescriberContract::class, Describer::class);
    }
}
