<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class DataBuilderFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('name', $faker->name);
        $bag->set('description', $faker->text);
        $bag->set('class_name', \Railken\Amethyst\DataBuilders\DummyDataBuilder::class);
        $bag->set('filter', 'id eq 1');
        $bag->set('input', [
            'date' => [
                'type'       => 'date',
                'validation' => 'date_format:Y-m-d',
            ],
        ]);
        $bag->set('mock_data', [
            'date' => '2018-01-01',
        ]);

        return $bag;
    }
}
