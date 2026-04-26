<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Resource\UserResource;

require_once dirname(__DIR__, 2) . '/app/resources/UserResource.php';

class UserResourceTest extends TestCase
{
    public function testDefaultModeOmitsRoleField(): void
    {
        $user = (object)[
            'id' => 10,
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'role' => 'admin',
        ];

        $payload = UserResource::make($user);

        $this->assertIsArray($payload);
        $this->assertSame(10, $payload['id']);
        $this->assertSame('Alice', $payload['name']);
        $this->assertSame('alice@example.com', $payload['email']);
        $this->assertArrayNotHasKey('role', $payload);
    }

    public function testSelfModeIncludesRoleField(): void
    {
        $user = (object)[
            'id' => 10,
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'role' => 'staff',
        ];

        $viewer = (object)[
            'id' => 10,
            'role' => 'user',
        ];

        $payload = UserResource::make($user, [
            'viewer' => $viewer,
            'mode' => 'self',
        ]);

        $this->assertIsArray($payload);
        $this->assertSame('staff', $payload['role'] ?? null);
    }
}
