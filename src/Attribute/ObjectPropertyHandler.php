<?php

namespace Tibisoft\AutoTransformer\Attribute;

use Tibisoft\AutoTransformer\Exception\TransformException;
use Tibisoft\AutoTransformer\ReflectionHelper;


class ObjectPropertyHandler implements AttributeHandlerInterface
{
    public function handle(BaseAttribute $attribute, \ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from): void
    {
        if (!($attribute instanceof ObjectProperty)) {
            return;
        }

        if (!$reflectionFrom->hasProperty($property->getName())) {
            return;
        }

        $fromProperty = $reflectionFrom->getProperty($property->getName());
        $object = $fromProperty->getValue($from);

        if (!is_object($object)) {
            return;
        }

        $reflectionObject = new \ReflectionClass($object);

        if (!ReflectionHelper::hasProperty($reflectionObject, $attribute->property)) {
            return;
        }

        $objectProperty = ReflectionHelper::getProperty($reflectionObject, $attribute->property);

        $property->setValue($to, $objectProperty->getValue($object));
    }
}
