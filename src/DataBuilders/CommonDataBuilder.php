<?php

namespace Railken\Amethyst\DataBuilders;

use Closure;
use Doctrine\Common\Inflector\Inflector;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Railken\Amethyst\Contracts\DataBuilderContract;
use Railken\Lem\Contracts\ManagerContract;

class CommonDataBuilder implements DataBuilderContract
{
    /**
     * @var \Railken\Amethyst\Managers\DataBuilderManager
     */
    protected $manager;

    /**
     * @var \Doctrine\Common\Inflector\Inflector
     */
    protected $inflector;

    /**
     * Create a new instance.
     */
    public function __construct($classManager)
    {
        if (!is_subclass_of($classManager, ManagerContract::class)) {
            throw new \Exception(sprintf('%s is invalid', $classManager));
        }

        $this->manager   = new $classManager();
        $this->inflector = new Inflector();
    }

    /**
     * Create a new instance of the query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery(): Builder
    {
        return $this->manager->getRepository()->newQuery();
    }

    /**
     * Retrieve the table name.
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->manager->newEntity()->getTable();
    }

    /**
     * Extract a single resource.
     *
     * @param Collection $resources
     * @param \Closure   $callback
     */
    public function extract(Collection $resources, Closure $callback)
    {
        foreach ($resources as $resource) {
            $callback($resource, [$this->inflector->singularize($this->getVariableName()) => $resource]);
        }
    }

    /**
     * Parse collection of resources.
     *
     * @param Collection $resources
     *
     * @return Collection
     */
    public function parse(Collection $resources): Collection
    {
        return new Collection([$this->inflector->pluralize($this->getVariableName()) => $resources]);
    }

    /**
     * Return the name of the variable that will be used from the data builder.
     *
     * @return string
     */
    public function getVariableName()
    {
        return $this->inflector->tableize($this->manager->getName());
    }
}
