<?php

namespace Tibisoft\AutoTransformer\Attribute;

use Tibisoft\AutoTransformer\Exception\TransformException;


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

        if (!$reflectionObject->hasProperty($attribute->property)) {
            return;
        }

        $objectProperty = $reflectionObject->getProperty($attribute->property);

        $property->setValue($to, $objectProperty->getValue($object));
    }
}
