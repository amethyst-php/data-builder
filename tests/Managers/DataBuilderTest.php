<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\DataBuilderFaker;
use Amethyst\Managers\DataBuilderManager;
use Amethyst\Tests\BaseTest;
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
        $bag->set('class_arguments', Yaml::dump([\Amethyst\Managers\FooManager::class]));

        return $bag;
    }

    public function testValidate()
    {
        /** @var \Amethyst\Managers\DataBuilderManager */
        $manager = $this->getManager();

        $errors = $manager->getValidator()->raw([
            'date' => 'date_format:Y-m-d',
        ], [
            'date' => '2018-01-01',
        ]);
        $this->assertEquals(0, $errors->count());

        $errors = $manager->getValidator()->raw([
            'date' => 'date_format:Y-m-d',
        ], [
            'date' => '2018-01-',
        ]);

        $this->assertEquals(1, $errors->count());

        $result = $manager->validateRaw($manager->create($this->getDataBuilderFaker())->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(true, $result->ok());
    }

    public function testBuild()
    {
        /** @var \Amethyst\Managers\DataBuilderManager */
        $manager = $this->getManager();

        $result = $manager->build($manager->create($this->getDataBuilderFaker())->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(true, $result->ok());

        $result = $manager->build($manager->create($this->getDataBuilderFaker()->set('filter', 'eq error'))->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(false, $result->ok());
    }

    public function testClassNameNull()
    {
        /** @var \Amethyst\Managers\DataBuilderManager */
        $manager = $this->getManager();

        $result = $manager->build($manager->create($this->getDataBuilderFaker()->set('class_name', null))->getResource(), [
            'date' => '2018-01-01',
        ]);

        $this->assertEquals(true, $result->ok());
    }
}
