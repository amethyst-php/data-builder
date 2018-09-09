<?php

namespace Railken\LaraOre\Tests\DataBuilder;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Api\Support\Testing\TestableTrait;
use Railken\LaraOre\DataBuilder\DataBuilderFaker;

class ApiTest extends BaseTest
{
    use TestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return Config::get('ore.api.http.admin.router.prefix').Config::get('ore.data-builder.http.admin.router.prefix');
    }

    /**
     * Test common requests.
     */
    public function testSuccessCommon()
    {
        $this->commonTest($this->getBaseUrl(), DataBuilderFaker::make()->parameters());
    }
}
