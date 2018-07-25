<?php

namespace Railken\LaraOre\DataBuilder\Attributes\Id\Exceptions;

use Railken\LaraOre\DataBuilder\Exceptions\DataBuilderAttributeException;

class DataBuilderIdNotUniqueException extends DataBuilderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATABUILDER_ID_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
