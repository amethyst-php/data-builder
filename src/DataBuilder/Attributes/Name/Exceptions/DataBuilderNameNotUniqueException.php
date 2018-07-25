<?php

namespace Railken\LaraOre\DataBuilder\Attributes\Name\Exceptions;

use Railken\LaraOre\DataBuilder\Exceptions\DataBuilderAttributeException;

class DataBuilderNameNotUniqueException extends DataBuilderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'name';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATABUILDER_NAME_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
