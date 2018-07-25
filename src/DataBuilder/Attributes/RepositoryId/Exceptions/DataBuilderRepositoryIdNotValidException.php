<?php

namespace Railken\LaraOre\DataBuilder\Attributes\RepositoryId\Exceptions;

use Railken\LaraOre\DataBuilder\Exceptions\DataBuilderAttributeException;

class DataBuilderRepositoryIdNotValidException extends DataBuilderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'repository_id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATABUILDER_REPOSITORY_ID_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
