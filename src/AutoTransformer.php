<?php

namespace Tibisoft\AutoTransformer;

use Tibisoft\AutoTransformer\Attribute\Count;
use Tibisoft\AutoTransformer\Attribute\Synonyms;
use Tibisoft\AutoTransformer\Exception\TransformException;

class AutoTransformer implements AutoTransformerInterface
{
    public function transform(object $from, string $to): object
    {
        $reflectionFrom = new \ReflectionClass($from);
        $reflectionTo = new \ReflectionClass($to);
        $to = $reflectionTo->newInstanceWithoutConstructor();

        foreach ($reflectionTo->getProperties() as $property) {
            //look for attribute
            $attributes = $property->getAttributes(Synonyms::class);
            if (count($attributes) > 0) {
               //find the first match!
                foreach ($attributes[0]->getArguments()[0] as $synonym) {
                    $this->setPropertyValue($reflectionFrom, $property, $to, $from, $synonym);
                    continue 2;
                }
            }

            $attributes = $property->getAttributes(Count::class);
            if (count($attributes) > 0) {
                $propertyFrom = $reflectionFrom->getProperty($property->getName());
                $value = $propertyFrom->getValue($from);
                if(is_countable($value)) {
                    $property->setValue($to, count($value));
                } else {
                    $property->setValue($to, 0);
                }
                continue;
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
     *
     * @return void
     */
    public function setPropertyValue(\ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from, string $propertyName = ''): void
    {
        $propertyName = ($propertyName === '') ? $property->getName() : $propertyName;

        try {
            if (!$reflectionFrom->hasProperty($propertyName)) {
                return;
            }

            $propertyFrom = $reflectionFrom->getProperty($propertyName);
            $property->setValue($to, $propertyFrom->getValue($from));
        } catch (\ReflectionException|\TypeError $typeError) {
            throw new TransformException($typeError->getMessage());
        }
    }
}
