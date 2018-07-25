<?php

namespace Railken\LaraOre\Tests\DataBuilder;

use Railken\LaraOre\DataBuilder\DataBuilderFaker;
use Railken\LaraOre\DataBuilder\DataBuilderManager;
use Railken\LaraOre\Support\Testing\ManagerTestableTrait;

class ManagerTest extends BaseTest
{
    use ManagerTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
        return new DataBuilderManager();
    }

    public function testSuccessCommon()
    {
        $this->commonTest($this->getManager(), DataBuilderFaker::make()->parameters());
    }
}
