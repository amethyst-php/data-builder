<?php

namespace Railken\LaraOre\DataBuilder\Exceptions;

class DataBuilderInputException extends DataBuilderException
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
