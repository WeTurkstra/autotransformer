<?php

namespace Tibisoft\AutoTransformer;

interface AutoTransformerInterface
{
    /**
     * @template T of object
     *
     * @param object $from
     * @param class-string<T>|T $to
     *
     * @return T
     */
    public function transform(object $from, string|object $to): object;
}
