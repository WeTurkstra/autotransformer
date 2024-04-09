<?php

class SomeClass
{
    public function __construct(
        public string $someString,
        public int    $someInt,
        public float  $someFloat,
        public bool   $someBool,
    )
    {

    }
}

class SomeNullableClass
{
    public function __construct(
        public ?string $someString,
        public ?int    $someInt,
        public ?float  $someFloat,
        public ?bool   $someBool,
    )
    {

    }
}

class SomeClassDTO
{
    public function __construct(
        public string $someString,
        public int    $someInt,
        public float  $someFloat,
        public bool   $someBool,
        public string $extraField,
    )
    {

    }
}


class SynonymClassDTO
{
    public function __construct(
        #[\Tibisoft\AutoTransformer\Attribute\Synonyms(['someInt'])]
        public int $customInt)
    {

    }
}
