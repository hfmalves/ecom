<?php

function categorize(array $items, string $key = 'category'): array
{
    $out = [];

    foreach ($items as $item) {
        $cat = $item[$key] ?? 'uncategorized';
        $out[$cat][] = $item;
    }

    return $out;
}