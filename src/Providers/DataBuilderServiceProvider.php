<?php

namespace Railken\Amethyst\Providers;

use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Console\Commands\DataBuilderSeed;

class DataBuilderServiceProvider extends CommonServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->commands([DataBuilderSeed::class]);

        $this->app->register(\Railken\Template\TemplateServiceProvider::class);
    }
}
