<?php

namespace Railken\Amethyst\Models;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Schemas\DataBuilderSchema;
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
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'input'         => 'object',
        'mock_data'     => 'object',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('amethyst.data-builder.managers.data-builder.table');
        $this->fillable = (new DataBuilderSchema())->getNameFillableAttributes();
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
