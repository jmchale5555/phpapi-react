<?php

namespace Controller\Api;

use Core\ApiController;
use Core\Session;
use Resource\UserResource;

defined('ROOTPATH') or exit('Access Denied');

class UserController extends ApiController
{
    public function index(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET')
        {
            $this->methodNotAllowed(['GET']);
            return;
        }

        $session = new Session();
        $user = $session->user();

        if (!$user)
        {
            $this->unauthenticated();
            return;
        }

        $this->ok([
            'user' => UserResource::make($user, ['viewer' => $user, 'mode' => 'self']),
        ]);
    }
}
