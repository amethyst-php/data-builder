<?php

namespace Railken\LaraOre\DataBuilder\Attributes\RepositoryId;

use Railken\Laravel\Manager\Attributes\BelongsToAttribute;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\Tokens;
use Respect\Validation\Validator as v;

class RepositoryIdAttribute extends BelongsToAttribute
{
    /**
     * Name attribute.
     *
     * @var string
     */
    protected $name = 'repository_id';

    /**
     * Is the attribute required
     * This will throw not_defined exception for non defined value and non existent model.
     *
     * @var bool
     */
    protected $required = true;

    /**
     * Is the attribute unique.
     *
     * @var bool
     */
    protected $unique = false;

    /**
     * List of all exceptions used in validation.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_DEFINED    => Exceptions\DataBuilderRepositoryIdNotDefinedException::class,
        Tokens::NOT_VALID      => Exceptions\DataBuilderRepositoryIdNotValidException::class,
        Tokens::NOT_AUTHORIZED => Exceptions\DataBuilderRepositoryIdNotAuthorizedException::class,
        Tokens::NOT_UNIQUE     => Exceptions\DataBuilderRepositoryIdNotUniqueException::class,
    ];

    /**
     * List of all permissions.
     */
    protected $permissions = [
        Tokens::PERMISSION_FILL => 'databuilder.attributes.repository_id.fill',
        Tokens::PERMISSION_SHOW => 'databuilder.attributes.repository_id.show',
    ];

    /**
     * Retrieve the name of the relation.
     *
     * @return string
     */
    public function getRelationName()
    {
        return 'repository';
    }

    /**
     * Retrieve eloquent relation.
     *
     * @param \Railken\LaraOre\FileGenerator\FileGenerator $entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getRelationBuilder(EntityContract $entity)
    {
        return $entity->repository();
    }

    /**
     * Retrieve relation manager.
     *
     * @param \Railken\LaraOre\FileGenerator\FileGenerator $entity
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getRelationManager(EntityContract $entity)
    {
        return new \Railken\LaraOre\Repository\RepositoryManager($this->getManager()->getAgent());
    }
}
