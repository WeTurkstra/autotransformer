<?php

namespace Tibisoft\AutoTransformer\Attribute;

class CountHandler implements AttributeHandlerInterface
{
    public function handle(BaseAttribute $attribute, \ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from): void
    {
        $propertyFrom = $reflectionFrom->getProperty($property->getName());
        $value = $propertyFrom->getValue($from);
        if(is_countable($value)) {
            $property->setValue($to, count($value));
        } else {
            $property->setValue($to, 0);
        }
    }
}
