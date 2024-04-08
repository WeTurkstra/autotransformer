<?php

namespace Tibisoft\AutoTransformer\Attribute;

use Assert\Assert;
use Assert\Assertion;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Synonyms extends BaseAttribute
{
    /**
     * @param array<int, string> $synonyms
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(public array $synonyms)
    {
        Assertion::notEmpty($this->synonyms);
    }
}
