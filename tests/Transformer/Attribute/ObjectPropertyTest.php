<?php

$object1 = new ObjectPropertyClass('Willem', new SubObjectPropertyClass('SomeValue'));
$object2 = new ObjectPropertyClass('Diego', new SubObjectPropertyClass('AnotherValue'));

test('Test object property Attribute', function ($object, $expected) {

    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var ObjectPropertyClassDTO $dto */
    $dto = $transformer->transform($object, ObjectPropertyClassDTO::class);

    expect($dto->name)->toBe($expected[0])
    ->and($dto->object)->toBe($expected[1]);
})->with([
    [$object1, ['Willem', 'SomeValue']],
    [$object2, ['Diego', 'AnotherValue']]
]);

class ObjectPropertyClass
{
    public function __construct(public string $name, public SubObjectPropertyClass $object)
    {

    }
}

class SubObjectPropertyClass
{
    public function __construct(public string $value)
    {

    }
}



class ObjectPropertyClassDTO
{
    public function __construct(
        public string $name,
        #[\Tibisoft\AutoTransformer\Attribute\ObjectProperty(property: 'value')]
        public string $object

    )
    {

    }
}
