<?php

test('Test ignore Attribute', function () {
    $object = new IgnoreClass(10, 'Willem Turkstra', ['test' => ['something' => 'missing']]);

    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var IgnoreClassDTO $dto */
    $dto = $transformer->transform($object, IgnoreClassDTO::class);

    expect($dto->age)->toBe($object->age);
    expect($dto->name)->toBe($object->name);

    $refProp = new ReflectionProperty($dto, 'complexArray');
    expect($refProp->isInitialized($dto))->toBe(false);

});

class IgnoreClass
{
    public function __construct(
        public int $age,
        public string $name,
        public array $complexArray,
    )
    {

    }
}

class IgnoreClassDTO
{
    public function __construct(
        public int $age,
        public string $name,
        #[\Tibisoft\AutoTransformer\Attribute\Ignore]
        public array $complexArray,
    )
    {

    }
}
