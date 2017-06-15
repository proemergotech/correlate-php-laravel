
## Overview

It's very difficult to track a request accross the system when we work microservices. We came out a solution for that. We generate a unique version 4 uuid for every request and every service passes this id via request header to other services. We call this **correlation ID**.

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
