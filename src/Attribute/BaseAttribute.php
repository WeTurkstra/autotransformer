<?php

namespace Tibisoft\AutoTransformer\Attribute;

abstract class BaseAttribute
{
    public function isHandledBy(): string
    {
        return static::class . 'Handler';
    }
}
