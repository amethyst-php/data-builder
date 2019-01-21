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
            'model'      => Railken\Amethyst\Models\DataBuilder::class,
            'schema'     => Railken\Amethyst\Schemas\DataBuilderSchema::class,
            'repository' => Railken\Amethyst\Repositories\DataBuilderRepository::class,
            'serializer' => Railken\Amethyst\Serializers\DataBuilderSerializer::class,
            'validator'  => Railken\Amethyst\Validators\DataBuilderValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\DataBuilderAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\DataBuilderFaker::class,
            'manager'    => Railken\Amethyst\Managers\DataBuilderManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'data-builder' => [
                'enabled'    => true,
                'controller' => Railken\Amethyst\Http\Controllers\Admin\DataBuildersController::class,
                'router'     => [
                    'as'     => 'data-builder.',
                    'prefix' => '/data-builders',
                ],
            ],
        ],
    ],
];
