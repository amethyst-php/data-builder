<?php

namespace Amethyst\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface DataBuilderContract
{
    /**
     * Create a new instance of the query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery(): Builder;

    /**
     * Retrieve the table name.
     *
     * @return string
     */
    public function getTableName(): string;

    /**
     * Extract a single resource.
     *
     * @param Collection $resources
     * @param \Closure   $callback
     */
    public function extract(Collection $resources, Closure $callback);

    /**
     * Parse collection of resources.
     *
     * @param Collection $resources
     *
     * @return Collection
     */
    public function parse(Collection $resources): Collection;
}
