<?php

namespace Tibisoft\AutoTransformer\Attribute;

use Tibisoft\AutoTransformer\Exception\TransformException;

class SynonymsHandler implements AttributeHandlerInterface
{
    public function handle(BaseAttribute $attribute, \ReflectionClass $reflectionFrom, \ReflectionProperty $property, object $to, object $from): void
    {
        if(!($attribute instanceof Synonyms)) {
            return;
        }

        //find the first match!
        foreach ($attribute->synonyms as $synonym) {
            $this->setPropertyValue($reflectionFrom, $property, $to, $from, $synonym);
        }
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
