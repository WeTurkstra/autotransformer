<?php

namespace Tibisoft\AutoTransformer;

interface AutoTransformerInterface
{
    /**
     * @template T of object
     *
     * @param object $from
     * @param class-string<T> $to
     *
     * @return T
     */
    public function transform(object $from, string $to): object;
}
