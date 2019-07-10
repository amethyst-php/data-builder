<?php

namespace Amethyst\Validators;

use Amethyst\Exceptions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use Railken\Lem\Validator;

class DataBuilderValidator extends Validator
{
    /**
     * Validate input submitted.
     *
     * @param array $schema
     * @param array $data
     *
     * @return \Illuminate\Support\Collection
     */
    public function raw(array $schema, array $data)
    {
        $errors = new Collection();

        if (count($schema) !== 0) {
            $validator = IlluminateValidator::make($data, $schema);

            foreach ($validator->errors()->getMessages() as $key => $error) {
                $errors[] = new Exceptions\DataBuilderInputException($key, $error[0], isset($data[$key]) ? $data[$key] : null);
            }
        }

        return $errors;
    }
}
