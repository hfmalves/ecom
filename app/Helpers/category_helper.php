<?php

function categorize(array $items): array
{
    $out = [];

    foreach ($items as $item) {
        $name = is_array($item) ? $item['name'] : $item->name;
        $slug = is_array($item) ? $item['slug'] : $item->slug;

        $out[$slug] = [
            'name'  => $name,
            'slug'  => $slug,
            'items' => $out[$slug]['items'] ?? [],
        ];

        $out[$slug]['items'][] = $item;
    }

    return $out;
}
