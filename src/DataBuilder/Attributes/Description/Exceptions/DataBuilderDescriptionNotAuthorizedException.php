<?php

namespace Railken\LaraOre\DataBuilder\Attributes\Description\Exceptions;

use Railken\LaraOre\DataBuilder\Exceptions\DataBuilderAttributeException;

class DataBuilderDescriptionNotAuthorizedException extends DataBuilderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'description';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATABUILDER_DESCRIPTION_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
