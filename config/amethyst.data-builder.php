<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components.
    |
    */
    'data' => [
        'data-builder' => [
            'table'      => 'amethyst_data_builders',
            'comment'    => 'Data Builder',
            'model'      => Amethyst\Models\DataBuilder::class,
            'schema'     => Amethyst\Schemas\DataBuilderSchema::class,
            'repository' => Amethyst\Repositories\DataBuilderRepository::class,
            'serializer' => Amethyst\Serializers\DataBuilderSerializer::class,
            'validator'  => Amethyst\Validators\DataBuilderValidator::class,
            'authorizer' => Amethyst\Authorizers\DataBuilderAuthorizer::class,
            'faker'      => Amethyst\Fakers\DataBuilderFaker::class,
            'manager'    => Amethyst\Managers\DataBuilderManager::class,
            'attributes' => [
                'class_name' => [
                    'options' => [
                        'common' => \Amethyst\DataBuilders\CommonDataBuilder::class
                    ]
                ]
            ]
        ],
    ],
];
