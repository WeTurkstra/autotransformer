<?php

namespace Tibisoft\AutoTransformer;

use Tibisoft\AutoTransformer\Attribute\AttributeHandlerInterface;
use Tibisoft\AutoTransformer\Attribute\BaseAttribute;
use Tibisoft\AutoTransformer\Attribute\Ignore;
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
                if($attribute instanceof Ignore) {
                    continue 2;
                }

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
            if (!ReflectionHelper::hasProperty($reflectionFrom, $propertyName)) {
                return;
            }

            $propertyFrom = ReflectionHelper::getProperty($reflectionFrom, $propertyName);
            $property->setValue($to, $propertyFrom->getValue($from));
        } catch (\ReflectionException|\TypeError $typeError) {
            throw new TransformException($typeError->getMessage());
        }
    }
}
