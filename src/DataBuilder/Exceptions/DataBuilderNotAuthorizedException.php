<?php

namespace Railken\LaraOre\DataBuilder\Exceptions;

class DataBuilderNotAuthorizedException extends DataBuilderException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATABUILDER_NOT_AUTHORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
