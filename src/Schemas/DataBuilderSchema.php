<?php

namespace Railken\Amethyst\Schemas;

use Railken\Amethyst\Managers\RepositoryManager;
use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class DataBuilderSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('name')
                ->setRequired(true)
                ->setUnique(true),
            Attributes\LongTextAttribute::make('description'),
            Attributes\BelongsToAttribute::make('repository_id')
                ->setRelationName('repository')
                ->setRelationManager(RepositoryManager::class),
            Attributes\ObjectAttribute::make('mock_data'),
            Attributes\ObjectAttribute::make('input'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
