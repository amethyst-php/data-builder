<?php

namespace Railken\Amethyst\Providers;

use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Console\Commands\DataBuilderSeed;
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
        $dataBuilders = array_merge(
            app('amethyst')->findClassesCached(base_path('app'), \Railken\Amethyst\Contracts\DataBuilderContract::class),
            [\Railken\Amethyst\DataBuilders\CommonDataBuilder::class]
        );

        Config::set('amethyst.data-builder.data.data-builder.attributes.class_name.options', $dataBuilders);
    }


}
