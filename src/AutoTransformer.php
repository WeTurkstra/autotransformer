<?php

namespace Tibisoft\AutoTransformer;

use Tibisoft\AutoTransformer\Attribute\AttributeHandlerInterface;
use Tibisoft\AutoTransformer\Attribute\BaseAttribute;
use Tibisoft\AutoTransformer\Exception\TransformException;

class AutoTransformer implements AutoTransformerInterface
{
    public function transform(object $from, string|object $to): object
    {
        $reflectionTo = new \ReflectionClass($to);
        if (!is_object($to)) {
            $to = $reflectionTo->newInstanceWithoutConstructor();
        }

        $reflectionFrom = new \ReflectionClass($from);

        foreach ($reflectionTo->getProperties() as $property) {
            //look for attribute
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                $attribute = $attribute->newInstance();
                if (!($attribute instanceof BaseAttribute)) {
                    continue;
                }

                if (class_exists($attribute->isHandledBy())) {
                    /** @var AttributeHandlerInterface $handler */
                    $handler = $attribute->isHandledBy();
                    $handler = new $handler();
                    $handler->handle($attribute, $reflectionFrom, $property, $to, $from);
                    continue 2;
                }
            }

            //do default
            $this->setPropertyValue($reflectionFrom, $property, $to, $from);
        }

        return $to;
    }

    /**
     * @param \ReflectionClass $reflectionFrom
     * @param \ReflectionProperty $property
     * @param object $to
     * @param object $from
     * @param string $propertyName
     *
     * @return void
     */
    public function setPropertyValue(\ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from, string $propertyName = ''): void
    {
        $propertyName = ($propertyName === '') ? $property->getName() : $propertyName;

        try {
            if (!$this->hasProperty($reflectionFrom, $propertyName)) {
                return;
            }

            $propertyFrom = $this->getProperty($reflectionFrom, $propertyName);
            $property->setValue($to, $propertyFrom->getValue($from));
        } catch (\ReflectionException|\TypeError $typeError) {
            throw new TransformException($typeError->getMessage());
        }
    }

    private function getProperty(\ReflectionClass $reflectionClass, string $propertyName): \ReflectionProperty
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

    private function hasProperty(\ReflectionClass $reflectionClass, string $propertyName): bool
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
