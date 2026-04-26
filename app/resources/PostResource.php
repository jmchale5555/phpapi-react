<?php

namespace Resource;

class PostResource
{
    public static function make(mixed $row): ?array
    {
        if (!$row)
        {
            return null;
        }

        return [
            'id' => isset($row->id) ? (int)$row->id : null,
            'user_id' => isset($row->user_id) ? (int)$row->user_id : null,
            'title' => $row->title ?? '',
            'body' => $row->body ?? '',
            'slug' => $row->slug ?? '',
            'is_published' => !empty($row->is_published),
            'published_at' => $row->published_at ?? null,
            'created_at' => $row->created_at ?? null,
            'updated_at' => $row->updated_at ?? null,
        ];
    }

    public static function collection(array $rows): array
    {
        return array_values(array_filter(array_map(function ($row) {
            return self::make($row);
        }, $rows)));
    }
}
