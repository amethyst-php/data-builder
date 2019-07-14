<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Amethyst\Exceptions;
use Amethyst\Models\DataBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Railken\Lem\Manager;
use Railken\Lem\Result;
use Symfony\Component\Yaml\Yaml;

/**
 * @method \Amethyst\Validators\DataBuilderValidator getValidator()
 */
/**
 * @method \Amethyst\Models\DataBuilder                 newEntity()
 * @method \Amethyst\Schemas\DataBuilderSchema          getSchema()
 * @method \Amethyst\Repositories\DataBuilderRepository getRepository()
 * @method \Amethyst\Serializers\DataBuilderSerializer  getSerializer()
 * @method \Amethyst\Validators\DataBuilderValidator    getValidator()
 * @method \Amethyst\Authorizers\DataBuilderAuthorizer  getAuthorizer()
 */
class DataBuilderManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.data-builder.data.data-builder';

    /**
     * Validate data.
     *
     * @param DataBuilder $builder
     * @param array       $data
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function validateRaw(DataBuilder $builder, array $data = [])
    {
        $schema = Collection::make(Yaml::parse((string) $builder->input))->map(function ($value) {
            return Arr::get((array) $value, 'validation');
        })->toArray();

        $result = new Result();
        $result->addErrors($this->getValidator()->raw($schema, $data));

        return $result;
    }

    /**
     * Render an email.
     *
     * @param DataBuilder $builder
     * @param array       $data
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function build(DataBuilder $builder, array $data = [])
    {
        $input = Yaml::parse((string) $builder->input);

        if ($data === null) {
            $data = Yaml::parse((string) $builder->mock_data);
        }

        $result = $this->validateRaw($builder, (array) $data);

        try {
            if ($builder->class_name !== null) {
                $query = $builder->newInstanceQuery((array) $data);

                $data = array_merge($data, $builder->parse($query->get())->all());
            }

            $result->setResources(new Collection([$data]));
        } catch (\PDOException | \Railken\SQ\Exceptions\QuerySyntaxException $e) {
            $e = new Exceptions\DataBuilderBuildException($e->getMessage());
            $result->addErrors(new Collection([$e]));
        }

        return $result;
    }
}
