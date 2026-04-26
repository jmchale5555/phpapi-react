<?php

use Core\Migration;
use Core\Schema;

class CreateUsersTable extends Migration
{
    public function up(Schema $schema): void
    {
        $schema->createTable('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role', 20)->default('user');
            $table->timestamps();
        });

        $schema->statement("ALTER TABLE `users` ADD CONSTRAINT `users_role_check` CHECK (`role` IN ('user', 'staff', 'admin'))");
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('users');
    }
}
