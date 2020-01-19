<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Console\Commands\DataBuilderSeed;
use Illuminate\Support\Facades\Config;

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

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        $dataBuilders = array_merge(
            app('amethyst')->findClassesCached(base_path('app'), \Amethyst\Contracts\DataBuilderContract::class),
            [\Amethyst\DataBuilders\CommonDataBuilder::class]
        );

        Config::set('amethyst.data-builder.data.data-builder.attributes.class_name.options', $dataBuilders);
    }
}
