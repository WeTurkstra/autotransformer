<?php

$someClass = new SomeClass("Test", 1, 1.2, true);
$someNullableClass = new SomeNullableClass(null, null, null, null,);

test('Basic transformation', function (SomeClass $someClass) {
    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var SomeClassDTO $dto */
    $dto = $transformer->transform($someClass, SomeClassDTO::class);

    expect($dto->someString)->toBe("Test");
    expect($dto->someInt)->toBe(1);
    expect($dto->someFloat)->toBe(1.2);
    expect($dto->someBool)->toBe(true);
})->with([$someClass]);

test('Expect an exception on type mismatch', function (SomeNullableClass $someClass) {
    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var SomeClassDTO $dto */
    $dto = $transformer->transform($someClass, SomeClassDTO::class);
})->with([$someNullableClass])->throws(\Tibisoft\AutoTransformer\Exception\TransformException::class);

test('Transform to existing object', function ($someClass) {
    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    $dto = new SomeClassDTO('AAA', 1, 1.5, true, 'EXTRA');

    /** @var SomeClassDTO $dto */
    $dto = $transformer->transform($someClass, $dto);

    expect($dto->someString)->toBe("Test");
    expect($dto->someInt)->toBe(1);
    expect($dto->someFloat)->toBe(1.2);
    expect($dto->someBool)->toBe(true);
    expect($dto->extraField)->toBe('EXTRA');
})->with([$someClass]);
