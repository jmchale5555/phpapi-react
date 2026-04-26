#!/usr/bin/env php
<?php

define('ROOTPATH', dirname(__DIR__) . '/public' . DIRECTORY_SEPARATOR);

require dirname(__DIR__) . '/app/core/init.php';

use Model\User;

function promptInput(string $label, bool $hidden = false): string
{
    fwrite(STDOUT, $label);

    $stdin = fopen('php://stdin', 'r');
    if ($stdin === false)
    {
        return '';
    }

    $canHide = $hidden && function_exists('stream_isatty') && stream_isatty(STDIN);

    if ($canHide)
    {
        $sttyMode = shell_exec('stty -g');
        if (is_string($sttyMode) && trim($sttyMode) !== '')
        {
            shell_exec('stty -echo');
            $line = fgets($stdin);
            shell_exec('stty ' . trim($sttyMode));
            fwrite(STDOUT, PHP_EOL);
            return trim((string)$line);
        }
    }

    $line = fgets($stdin);
    return trim((string)$line);
}

fwrite(STDOUT, "Seed initial admin user\n");
fwrite(STDOUT, "------------------------\n");

$email = promptInput('Admin email: ');
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL))
{
    fwrite(STDERR, "Invalid email address.\n");
    exit(1);
}

$password = promptInput('Admin password: ', true);
if (strlen($password) < 8)
{
    fwrite(STDERR, "Password must be at least 8 characters.\n");
    exit(1);
}

$confirm = promptInput('Confirm password: ', true);
if ($confirm !== $password)
{
    fwrite(STDERR, "Passwords do not match.\n");
    exit(1);
}

$userModel = new User();
$existing = $userModel->first(['email' => $email]);

if ($existing)
{
    fwrite(STDERR, "A user with that email already exists.\n");
    exit(1);
}

$name = 'Administrator';

$userModel->insert([
    'name' => $name,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT),
    'role' => 'admin',
]);

$created = $userModel->first(['email' => $email]);
if (!$created)
{
    fwrite(STDERR, "Failed to create admin user.\n");
    exit(1);
}

fwrite(STDOUT, "Admin user created for {$email}.\n");
