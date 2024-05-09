<?php


class ChildClass extends ParentClass {
    public function __construct(
        public string $foo,
        string $bar,
    )
    {
        parent::__construct($bar);
    }
}


class ParentClass {
    public function __construct(
        public string $bar)
    {

    }
}

class ChildParentDTO {
    public function __construct(
        public string $foo,
        public string $bar,
    )
    {

    }
}

$object1 = new ChildClass('Foo', 'Bar');
$object2 = new ChildClass('Some', 'Thing');

test('Test extended objects Attribute', function ($object, $expected) {

    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var ChildParentDTO $dto */
    $dto = $transformer->transform($object, ChildParentDTO::class);

    expect($dto->foo)->toBe($expected[0])
        ->and($dto->bar)->toBe($expected[1]);
})->with([
    [$object1, ['Foo', 'Bar']],
    [$object2, ['Some', 'Thing']],
]);
