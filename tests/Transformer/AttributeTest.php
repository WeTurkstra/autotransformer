<?php

$someClass = new SomeClass("Test", 1, 1.2, true);

test('Test counter', function ($someClass) {
    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var SynonymClassDTO $dto */
    $dto = $transformer->transform($someClass, SynonymClassDTO::class);

    expect($dto->customInt)->toBe($someClass->someInt);
})->with([$someClass]);
