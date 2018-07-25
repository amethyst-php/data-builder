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

    public function testValidate()
    {
        $errors = $this->getManager()->getValidator()->raw([
            'date' => 'date_format:Y-m-d',
        ], [
            'date' => '2018-01-01',
        ]);
        $this->assertEquals(0, $errors->count());

        $errors = $this->getManager()->getValidator()->raw([
            'date' => 'date_format:Y-m-d',
        ], [
            'date' => '2018-01-',
        ]);

        $this->assertEquals(1, $errors->count());
    }
}
