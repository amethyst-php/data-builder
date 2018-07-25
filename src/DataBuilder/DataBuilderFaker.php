<?php

namespace Railken\LaraOre\DataBuilder;

use Faker\Factory;
use Railken\Bag;
use Railken\LaraOre\Repository\RepositoryFaker;
use Railken\Laravel\Manager\BaseFaker;

class DataBuilderFaker extends BaseFaker
{
    /**
     * @var string
     */
    protected $manager = DataBuilderManager::class;

    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('name', $faker->name);
        $bag->set('description', $faker->text);
        $bag->set('repository', RepositoryFaker::make()->parameters()->toArray());
        $bag->set('input', [
            'name' => 'string',
        ]);
        $bag->set('mock_data', [
            'name' => 'adc',
        ]);

        return $bag;
    }
}
