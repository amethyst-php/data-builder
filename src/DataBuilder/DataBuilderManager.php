<?php

namespace Railken\LaraOre\DataBuilder;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Result;
use Railken\Laravel\Manager\Tokens;

class DataBuilderManager extends ModelManager
{
    /**
     * Class name entity.
     *
     * @var string
     */
    public $entity = DataBuilder::class;

    /**
     * List of all attributes.
     *
     * @var array
     */
    protected $attributes = [
        Attributes\Id\IdAttribute::class,
        Attributes\Name\NameAttribute::class,
        Attributes\Description\DescriptionAttribute::class,
        Attributes\CreatedAt\CreatedAtAttribute::class,
        Attributes\UpdatedAt\UpdatedAtAttribute::class,
        Attributes\DeletedAt\DeletedAtAttribute::class,
        Attributes\Input\InputAttribute::class,
        Attributes\RepositoryId\RepositoryIdAttribute::class,
        Attributes\MockData\MockDataAttribute::class,
    ];

    /**
     * List of all exceptions.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_AUTHORIZED => Exceptions\DataBuilderNotAuthorizedException::class,
    ];

    /**
     * Construct.
     *
     * @param AgentContract $agent
     */
    public function __construct(AgentContract $agent = null)
    {
        $this->entity = Config::get('ore.data-builder.entity');
        $this->attributes = array_merge($this->attributes, array_values(Config::get('ore.data-builder.attributes')));

        $classRepository = Config::get('ore.data-builder.repository');
        $this->setRepository(new $classRepository($this));

        $classSerializer = Config::get('ore.data-builder.serializer');
        $this->setSerializer(new $classSerializer($this));

        $classAuthorizer = Config::get('ore.data-builder.authorizer');
        $this->setAuthorizer(new $classAuthorizer($this));

        $classValidator = Config::get('ore.data-builder.validator');
        $this->setValidator(new $classValidator($this));

        parent::__construct($agent);
    }

    /**
     * Validate data.
     *
     * @param DataBuilder $builder
     * @param array       $data
     *
     * @return \Railken\Laravel\Manager\Contracts\ResultContract
     */
    public function validateRaw(DataBuilder $builder, array $data = [])
    {
        $schema = Collection::make($builder->input)->map(function ($value) {
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
     * @return \Railken\Laravel\Manager\Contracts\ResultContract
     */
    public function build(DataBuilder $builder, array $data = [])
    {
        $repository = $builder->repository;
        $input = $builder->input;

        if ($data === null) {
            $data = $builder->mock_data;
        }

        $result = $this->validateRaw($builder, (array) $data);

        try {
            $query = $repository->newInstanceQuery($data);

            $data = array_merge($data, (array) $repository->parse($query->get()));

            $result->setResources(new Collection([$data]));
        } catch (\PDOException | \Railken\SQ\Exceptions\QuerySyntaxException $e) {
            $e = new Exceptions\DataBuilderBuildException($e->getMessage());
            $result->addErrors(new Collection([$e]));
        }

        return $result;
    }
}
