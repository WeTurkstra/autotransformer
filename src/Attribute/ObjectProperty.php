<?php

namespace Tibisoft\AutoTransformer\Attribute;


#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ObjectProperty extends BaseAttribute
{
    public function __construct(public string $property)
    {

    }
}
