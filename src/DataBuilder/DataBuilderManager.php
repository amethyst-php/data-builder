<?php

namespace Railken\LaraOre\DataBuilder;

use Illuminate\Support\Facades\Config;
use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\ModelManager;
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
}
