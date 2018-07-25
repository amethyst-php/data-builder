<?php

namespace Railken\LaraOre\DataBuilder;

use Railken\Laravel\Manager\ModelAuthorizer;
use Railken\Laravel\Manager\Tokens;

class DataBuilderAuthorizer extends ModelAuthorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'data_builder.create',
        Tokens::PERMISSION_UPDATE => 'data_builder.update',
        Tokens::PERMISSION_SHOW   => 'data_builder.show',
        Tokens::PERMISSION_REMOVE => 'data_builder.remove',
    ];
}
