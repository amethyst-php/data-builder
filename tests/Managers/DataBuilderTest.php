<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\DataBuilderFaker;
use Railken\Amethyst\Managers\DataBuilderManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;
use Symfony\Component\Yaml\Yaml;

class DataBuilderTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = DataBuilderManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = DataBuilderFaker::class;

    public function getDataBuilderFaker()
    {
        $bag = DataBuilderFaker::make()->parameters();
        $bag->set('class_arguments', Yaml::dump([\Railken\Amethyst\Managers\FooManager::class]));

        return $bag;
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

        $result = $this->getManager()->validateRaw($this->getManager()->create($this->getDataBuilderFaker())->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(true, $result->ok());
    }

    public function testBuild()
    {
        $result = $this->getManager()->build($this->getManager()->create($this->getDataBuilderFaker())->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(true, $result->ok());

        $result = $this->getManager()->build($this->getManager()->create($this->getDataBuilderFaker()->set('filter', 'eq error'))->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(false, $result->ok());
    }

    public function testClassNameNull()
    {
        $result = $this->getManager()->build($this->getManager()->create($this->getDataBuilderFaker()->set('class_name', null))->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(true, $result->ok());
    }
}
