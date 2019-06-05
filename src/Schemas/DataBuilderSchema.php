<?php

namespace Railken\Amethyst\Schemas;

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
            Attributes\TextAttribute::make('filter'),
            Attributes\EnumAttribute::make('class_name', config('amethyst.data-builder.data.data-builder.attributes.class_name.options')),
            Attributes\YamlAttribute::make('class_arguments'),
            Attributes\YamlAttribute::make('mock_data'),
            Attributes\YamlAttribute::make('input'),
            Attributes\TextAttribute::make('include'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
            Attributes\DeletedAtAttribute::make(),
        ];
    }
}
