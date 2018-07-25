<?php

namespace Railken\LaraOre\DataBuilder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Repository\Repository;
use Railken\Laravel\Manager\Contracts\EntityContract;

/**
 * @property string     $name
 * @property string     $description
 * @property object     $mock_data
 * @property object     $input
 * @property Repository $repository
 */
class DataBuilder extends Model implements EntityContract
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_builder';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'input',
        'mock_data',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
        $this->table = Config::get('ore.data-builder.table');
        $this->fillable = array_merge($this->fillable, array_keys(Config::get('ore.data-builder.attributes')));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
