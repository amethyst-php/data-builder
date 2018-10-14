<?php

namespace Railken\Amethyst\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Railken\Amethyst\Common\ConfigurableModel;
use Railken\LaraEye\Filter;
use Railken\Lem\Contracts\EntityContract;
use Railken\Template\Generators\TextGenerator;

/**
 * @property object $input
 * @property object $mock_data
 * @property string $class_name
 */
class DataBuilder extends Model implements EntityContract
{
    use SoftDeletes, ConfigurableModel;

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
    public function newInstanceQuery(array $data = [], array $selectable = ['*'])
    {
        $tm = new TextGenerator();

        $r = $this->newInstanceData();
        $query = $r->newQuery();

        if (!empty($this->filter)) {
            $filter = new Filter($r->getTableName(), $selectable);
            $filter->build($query, $tm->generateAndRender($this->filter, $data));
        }

        return $query;
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
     * @return \Railken\Amethyst\Contracts\DataBuilderContract
     */
    public function newInstanceData()
    {
        return new $this->class_name();
    }
}
