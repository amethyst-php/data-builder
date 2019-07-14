<?php

namespace Amethyst\Models;

use Amethyst\Common\ConfigurableModel;
use Amethyst\Contracts\DataBuilderContract;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Railken\EloquentMapper\Joiner;
use Railken\LaraEye\Filter;
use Railken\Lem\Contracts\EntityContract;
use Railken\Template\Generators\TextGenerator;
use Symfony\Component\Yaml\Yaml;

/**
 * @property object $input
 * @property object $mock_data
 * @property string $class_name
 * @property string $class_arguments
 * @property string $include
 */
class DataBuilder extends Model implements EntityContract
{
    use SoftDeletes;
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.data-builder.data.data-builder');
        parent::__construct($attributes);
    }

    /**
     * New query instance.
     *
     * @param array $data
     * @param array $selectable
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newInstanceQuery(array $data, array $selectable = ['*']): Builder
    {
        $tm = new TextGenerator();

        $r = $this->newInstanceData();
        $query = $r->newQuery();

        if (!empty($this->filter)) {
            $filter = new Filter($r->getTableName(), $selectable);
            $filter->build($query, $tm->generateAndRender($this->filter, $data));
        }

        $this->autoJoin($r, $query);

        return $query;
    }

    /**
     * @param \Amethyst\Contracts\DataBuilderContract $dataBuilder
     * @param \Illuminate\Database\Eloquent\Builder   $query
     */
    public function autoJoin(DataBuilderContract $dataBuilder, Builder $query)
    {
        $joiner = new Joiner($query);
        $class = get_class($dataBuilder->getManager()->newEntity());
        $relations = Collection::make(app('eloquent.mapper')->getFinder()->mapKeysRelation($class))
            ->filter(function ($item) {
                return in_array($item, $this->getIncludes(), true);
            })
            ->map(function ($item) use ($query) {
                $query->with($item);

                return $item;
            })
            ->toArray();

        app('eloquent.mapper')->getFinder()->mapRelations($class, function ($prefix, $relation) use ($joiner, $relations) {
            $key = $prefix ? $prefix.'.'.$relation->name : $relation->name;

            if (!in_array($key, $relations, true)) {
                return;
            }

            $joiner->joinRelations($key);

            return [$key, [$key]];
        });
    }

    /**
     * @param Collection $resources
     * @param \Closure   $callback
     */
    public function extract(Collection $resources, Closure $callback)
    {
        return $this->newInstanceData()->extract($resources, $callback);
    }

    /**
     * @param Collection $resources
     *
     * @return Collection
     */
    public function parse(Collection $resources)
    {
        return $this->newInstanceData()->parse($resources);
    }

    /**
     * New instance data builder custom.
     *
     * @return \Amethyst\Contracts\DataBuilderContract
     */
    public function newInstanceData()
    {
        $className = $this->class_name;

        $arguments = (array) Yaml::parse(strval($this->class_arguments));

        return new $className(...$arguments);
    }

    /**
     * @return array
     */
    public function getIncludes()
    {
        return Yaml::parse((string) $this->include);
    }
}
