<?php

namespace Tibisoft\AutoTransformer;

class ReflectionHelper
{
    public static function getProperty(\ReflectionClass $reflectionClass, string $propertyName): \ReflectionProperty
    {
        try {
            return $reflectionClass->getProperty($propertyName);
        } catch (\ReflectionException|\TypeError $typeError) {
            if ($reflectionClass->getParentClass() !== false) {
                return $reflectionClass->getParentClass()->getProperty($propertyName);
            }

            throw $typeError;
        }
    }

    public static function hasProperty(\ReflectionClass $reflectionClass, string $propertyName): bool
    {
        if ($reflectionClass->hasProperty($propertyName)) {
            return true;
        }

        if ($reflectionClass->getParentClass() !== false) {
            return $reflectionClass->getParentClass()->hasProperty($propertyName);
        }

        return false;
    }
}
