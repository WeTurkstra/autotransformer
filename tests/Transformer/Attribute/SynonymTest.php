<?php

$object1 = new SynonymsClass('Willem');
$object2 = new SynonymsClass('Diego');

$object3 = new Synonyms1Class('Bianca');
$object4 = new Synonyms1Class('Mariska');

test('Test synonym Attribute', function ($object, $expected) {

    $transformer = new \Tibisoft\AutoTransformer\AutoTransformer();

    /** @var SynonymsDTO $dto */
    $dto = $transformer->transform($object, SynonymsDTO::class);

    expect($dto->username)->toBe($expected);
})->with([
    [$object1, 'Willem'],
    [$object2, 'Diego'],
    [$object3, 'Bianca'],
    [$object4, 'Mariska'],
]);

class SynonymsClass
{
    public function __construct(public string $name)
    {

    }
}
class Synonyms1Class
{
    public function __construct(public string $lastname)
    {

    }
}

class SynonymsDTO
{
    public function __construct(
        #[\Tibisoft\AutoTransformer\Attribute\Synonyms(synonyms: ['lastname', 'name'])]
        public string $username)
    {

    }
}
