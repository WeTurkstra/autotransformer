<?php

namespace Tibisoft\AutoTransformer\Attribute;

use Tibisoft\AutoTransformer\Exception\TransformException;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class InArrayHandler implements AttributeHandlerInterface
{
    public function handle(BaseAttribute $attribute, \ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from): void
    {
        if (!($attribute instanceof InArray)) {
            return;
        }

        if (!$reflectionFrom->hasProperty($attribute->property)) {
            return;
        }

        $propertyFrom = $reflectionFrom->getProperty($attribute->property);
        $array = $propertyFrom->getValue($from);
        if(!is_array($array)) {
            return;
        }

        $property->setValue($to, in_array($attribute->value, $array));
    }
}
