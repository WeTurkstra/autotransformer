<?php

test('Test count Attribute', function () {
    $object = new CountClass([1,2,3,4,5]);

    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var CountClassDTO $dto */
    $dto = $transformer->transform($object, CountClassDTO::class);

    expect($dto->items)->toBe(5);
});

class CountClass
{
    public function __construct(public array $items = [])
    {

    }
}

class CountClassDTO
{
    public function __construct(
        #[\Tibisoft\AutoTransformer\Attribute\Count]
        public int $items)
    {

    }
}
