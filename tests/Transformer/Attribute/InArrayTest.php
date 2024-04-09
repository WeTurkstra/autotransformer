<?php

$object1 = new InArrayClass(['ROLE_USER', 'ROLE_TEAMLEADER']);
$object2 = new InArrayClass(['ROLE_USER', 'ROLE_TEST']);

test('Test inarray Attribute', function ($object, $expected) {

    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var InArrayDTO $dto */
    $dto = $transformer->transform($object, InArrayDTO::class);

    expect($dto->isTeamleader)->toBe($expected);
})->with([
    [$object1, true],
    [$object2, false],
]);

class InArrayClass
{
    public function __construct(public array $roles = [])
    {

    }
}

class InArrayDTO
{
    public function __construct(
        #[\Tibisoft\AutoTransformer\Attribute\InArray(property: 'roles', value: 'ROLE_TEAMLEADER')]
        public bool $isTeamleader)
    {

    }
}
