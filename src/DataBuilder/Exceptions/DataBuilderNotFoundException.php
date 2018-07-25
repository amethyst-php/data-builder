<?php

namespace Railken\LaraOre\DataBuilder\Exceptions;

class DataBuilderNotFoundException extends DataBuilderException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATABUILDER_NOT_FOUND';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'Not found';
}
