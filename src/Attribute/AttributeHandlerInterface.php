<?php

namespace Tibisoft\AutoTransformer\Attribute;

interface AttributeHandlerInterface
{
    public function handle(BaseAttribute $attribute, \ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from): void;
}
