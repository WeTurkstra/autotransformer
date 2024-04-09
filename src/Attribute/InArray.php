<?php

namespace Tibisoft\AutoTransformer\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class InArray extends BaseAttribute
{
    public function __construct(public string $property, public mixed $value)
    {

    }
}
