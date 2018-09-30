<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class DataBuilderAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'data-builder.create',
        Tokens::PERMISSION_UPDATE => 'data-builder.update',
        Tokens::PERMISSION_SHOW   => 'data-builder.show',
        Tokens::PERMISSION_REMOVE => 'data-builder.remove',
    ];
}
