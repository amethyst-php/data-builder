<?php

namespace Railken\Amethyst\Exceptions;

use Railken\Lem\Exceptions\ModelException;

class DataBuilderInputException extends ModelException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'DATA-BUILDER_INPUT_INVALID';

    /**
     * Construct.
     *
     * @param string $key
     * @param mixed  $message
     * @param mixed  $value
     */
    public function __construct($key, $message = null, $value = null)
    {
        $this->value = $value;
        $this->label = $key;
        $this->message = $message;

        parent::__construct();
    }
}
