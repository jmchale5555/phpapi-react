<?php

namespace Resource;

class UserResource
{
    public static function make(mixed $user, array $context = []): ?array
    {
        if (!$user)
        {
            return null;
        }

        $viewer = $context['viewer'] ?? null;
        $mode = (string)($context['mode'] ?? 'default');

        $payload = [
            'id' => isset($user->id) ? (int)$user->id : null,
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
        ];

        $isSelf = isset($viewer->id, $user->id) && (int)$viewer->id === (int)$user->id;
        $isAdmin = isset($viewer->role) && $viewer->role === 'admin';

        if ($mode === 'self' || $isSelf || $isAdmin)
        {
            $payload['role'] = $user->role ?? 'user';
        }

        return $payload;
    }

    public static function collection(array $users, array $context = []): array
    {
        return array_values(array_filter(array_map(function ($user) use ($context) {
            return self::make($user, $context);
        }, $users)));
    }
}
