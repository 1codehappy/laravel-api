# Laravel Api

A simple, a modern and an elegant Laravel boilerpate for your api, applying Domain Driven Design and hexagonal architecture principles based on [Laravel Beyond Crud](https://laravel-beyond-crud.com/).

## Features

- Laravel 9 [Github](https://github.com/laravel/framework) [Docs](https://laravel.com/docs/)
- GitHub Actions [CI](https://github.com/1codehappy/laravel-api/actions)
- Api restful
- JWT Auth
- ACL & Laravel Policies
- PestPHP tests
- OpenApi docs

## Installation

Create your project using composer.

```bash
composer create-project 1codehappy/laravel-api api
```

## Directories


See the directory structure bellow:

```
|-- app/
    |-- Backend # Api & Artisan commands
    |-- Domain # Domains
    |-- Support # Commons & Api Documentation
```

## Factories

```php
<?php

$user = User::factory()->hasRoles()->hasPermissions()->create();
$roles = Role::factory()->hasPermissions()->count(2)->create();
$permissions = Permission::factory()->count(3)->create();

$user->assignRole($roles->pluck('name')->all()) # Assign 2 random roles.
  ->givePermissionTo($permissions->pluck('name')->all()) # Give 3 random permissions.
  ->load('roles', 'permissions'); # Load object relations.
```

## Routes

- **Authentication:**
   - **POST** `/auth/login`: Sign in.
   - **POST** `/auth/logout`: Sign out.
   - **POST** `/auth/refresh`: Refresh the JWT Token.
- **User's profile:**
   - **GET** `/auth/me`: Get authenticated user's profile.
   - **PUT** `/auth/me`: Edit authenticated user's profile.
   - **PUT** `/auth/me/password`: Change authenticated user's password.
- **ACL:**
   - **GET** `/permissions`: Get the permission list.
   - **GET** `/roles`: Get the role list.
   - **GET** `/roles/{uuid}`: Get the role.
   - **POST** `/roles`: Create a new role.
   - **PUT** `/roles/{uuid}`: Edit the role.
   - **DELETE** `/roles/{uuid}`: Delete the role.
- **Users:**
   - **GET** `/users/`: Get the user list.
   - **GET** `/users/{uuid}`: Get the user.
   - **POST** `/users`: Create a new user.
   - **PUT** `/users/{uuid}`: Edit the user.
   - **DELETE** `/users/{uuid}`: Delete the user.

## Api Documentation

- **GET** `/api-docs`: Get the api documention.
- `php artisan l5-swagger:generate`: Generate the api docs.

## PHP Libraries

- Laracasts Presenter [GitHub](https://github.com/laracasts/Presenter)
- PHP Open Source Saver JWT [GitHub](https://github.com/php-open-source-saver/jwt-auth) [Docs](https://laravel-jwt-auth.readthedocs.io/en/latest/)
- Jess Archer Castable [GitHub](https://github.com/jessarcher/laravel-castable-data-transfer-object)
- Spatie Data Transfer Objects [GitHub](https://github.com/spatie/data-transfer-object)
- Spatie Laravel Fractal [GitHub](https://github.com/spatie/laravel-fractal)
- Spatie Laravel Query Builder [GitHub](https://github.com/spatie/laravel-query-builder) [Docs](https://spatie.be/docs/laravel-query-builder)
- Spatie Permissions [Github](https://github.com/spatie/laravel-permission) [Docs](https://spatie.be/docs/laravel-permission)
- Darka On Line Swagger [GitHub](https://github.com/DarkaOnLine/L5-Swagger)
- FriendsOfPHP CS Fixer [GitHub](https://github.com/FriendsOfPHP/PHP-CS-Fixer) [Docs](https://cs.symfony.com/)
- Laravel IDE Helper [GitHub](https://github.com/barryvdh/laravel-ide-helper)
- Larastan [GitHub](https://github.com/nunomaduro/larastan) [Docs](https://phpstan.org/user-guide/getting-started)
- PestPHP [GitHub](https://github.com/pestphp/pest) [Docs](https://pestphp.com/docs/installation)
- Enlightn Security Checker [GitHub](https://github.com/enlightn/security-checker)

## Composer Scripts

- `composer clear`: Clear laravel cache
- `composer optimize`: Optimize api
- `composer cs`: Fix coding style
- `composer analyse`: Run larastan
- `composer test`: Run pestphp
- `composer sec`: Check the php libraries

---

<sub>by **CodeHappy ;)**</sub>
