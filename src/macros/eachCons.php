<?php

use Illuminate\Support\Collection;

/*
 * Get the consecutive values in the collection defined by the given chunk size.
 *
 * @param int $chunkSize
 * @param bool $preserveKeys
 *
 * @return \Illuminate\Support\Collection
 */
Collection::macro('eachCons', function (int $chunkSize, bool $preserveKeys = false): Collection {
    $size = $this->count() - $chunkSize + 1;
    $result = collect(range(0, $size))->reduce(function ($result, $index) use ($chunkSize, $preserveKeys) {
        $next = $this->slice($index, $chunkSize);

        return $next->count() === $chunkSize ? $result->push($preserveKeys ? $next : $next->values()) : $result;
    }, new static([]));

    return $preserveKeys ? $result : $result->values();
});
