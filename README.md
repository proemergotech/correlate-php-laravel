# correlate-php-laravel

---

## Overview

It's very difficult to track a request accross the system when we are working with microservices. We came out a solution for that. We generate a unique version 4 uuid for every request and every service passes this id via request header to other services. We call this **correlation ID**.

## Packages

- [proemergotech/correlate-php-laravel](https://github.com/proemergotech/correlate-php-laravel)
  - Middleware for Laravel and Lumen frameworks.
- [proemergotech/correlate-php-psr-7](https://github.com/proemergotech/correlate-php-psr-7)
  - Middleware for any PSR-7 compatible frameworks like [Slim Framework](https://www.slimframework.com/).
- [proemergotech/correlate-php-monolog](https://github.com/proemergotech/correlate-php-monolog)
  - Monolog processor for correlate middlewares (you don't have to use this directly).
- [proemergotech/correlate-php-guzzle](https://github.com/proemergotech/correlate-php-guzzle)
  - Guzzle middleware to add correlation id to every requests.
- [proemergotech/correlate-php-core](https://github.com/proemergotech/correlate-php-core)
  - Common package for correlate id middlewares to provide consistent header naming accross projects.

## Installation

- Install via composer

```sh
composer require proemergotech/correlate-php-laravel
```

## Setup for Laravel 5

Add serverice provider to config/app.php in your Laravel project.

```php
// config/app.php

    'providers' => [
        ...

        \ProEmergotech\Correlate\Laravel\LaravelCorrelateServiceProvider::class,
    ],
```

## Setup for Lumen 5

Add serverice provider to bootstrap/app.php in your Lumen project.

```php
// bootstrap/app.php

$app->register(\ProEmergotech\Correlate\Laravel\LaravelCorrelateServiceProvider::class);

```

## Usage

This middleware automatically adds correlation id (coming from request header) to every log messages.

There are some macros added to request object if you want to work with correlation id.

Using macros via Request facade:

```php
if (Request::hasCorrelationId()) {
  $cid = Request::getCorrelationId();
}
// or if you can change the ID
Request::setCorrelationId(\ProEmergotech\Correlate\Correlate::id());
```

Using macros via request object:

```php
if ($request->hasCorrelationId()) {
  $cid = $request->getCorrelationId();
}
// or if you can change the ID
$request->setCorrelationId(\ProEmergotech\Correlate\Correlate::id());
```

## Contributing

See `CONTRIBUTING.md` file.

## Credits

This package developed by [Soma Szélpál](https://github.com/shakahl/) at [Pro Emergotech Ltd.](https://github.com/proemergotech/).

## License

This project is released under the [MIT License](http://www.opensource.org/licenses/MIT).
