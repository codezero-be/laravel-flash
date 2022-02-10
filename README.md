# Flash Notifications for Laravel

[![GitHub release](https://img.shields.io/github/release/codezero-be/laravel-flash.svg?style=flat-square)](https://github.com/codezero-be/laravel-flash/releases)
[![Laravel](https://img.shields.io/badge/laravel-9-red?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![License](https://img.shields.io/packagist/l/codezero/laravel-flash.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/codezero-be/laravel-flash/Tests/master?style=flat-square&logo=github&logoColor=white&label=tests)](https://github.com/codezero-be/laravel-flash/actions)
[![Code Coverage](https://img.shields.io/codacy/coverage/22d50bd2782540bb806f576966a5f5d5/master?style=flat-square)](https://app.codacy.com/gh/codezero-be/laravel-flash)
[![Code Quality](https://img.shields.io/codacy/grade/22d50bd2782540bb806f576966a5f5d5/master?style=flat-square)](https://app.codacy.com/gh/codezero-be/laravel-flash)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/laravel-flash.svg?style=flat-square)](https://packagist.org/packages/codezero/laravel-flash)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R3UQ8V)

#### Flash messages to the session with [Laravel](http://laravel.com/).

## 🧩 Features

- Flash multiple messages.
- Use built in notification levels (success, error, ...) or imagine your own.

## ✅ Requirements

- PHP >= 7.2
- Laravel >= 6.0

## 📦 Install

```bash
composer require codezero/laravel-flash
```

> Laravel will automatically register the ServiceProvider.

## 🛠 Usage

Somewhere in your views, include the flash notifications partial:

```blade
@include('flash::notifications')
```

Then you can flash a message to the session in your controllers.

```php
flash()->success('Update succeeded!');
```

> You can also use the facade `\CodeZero\Flash\Facades\Flash` instead of the `flash()` helper.

The message will be displayed once on the next page load.

## 🚨 Notification Levels

You can use the built in notification levels:

```php
flash()->info('info message');
flash()->success('success message');
flash()->warning('warning message');
flash()->error('error message');
```

Or you can specify a custom level:

```php
flash()->notification('message', 'level');
```

## 🔖 Rendering Notifications

### Customize the notification views

If you want to customize the templates, you can publish the views:

```bash
php artisan vendor:publish --provider="CodeZero\Flash\FlashServiceProvider" --tag="views"
```

You will find the views in `resources/views/vendor/flash`.

### Default views for built in notification levels

A notification will be rendered using a view file which name corresponds with the notification level.

So `flash()->success('message')` will load a `success.blade.php` view file.

These views live in `resources/views/vendor/flash/notifications`.

### Default view for custom notification levels

If no corresponding file can be found in the package's view folder, then the `default.blade.php` view file will be used.

So `flash()->notification('message', 'custom')` will load the `default.blade.php` view file.

This view lives in `resources/views/vendor/flash/notifications`.

### Add views for custom notification levels

To add view files for custom levels, create them in `resources/views/vendor/flash/notifications`.

### Override default notification views

You can override the view file to be used when you flash a notification:

```php
// use 'resources/views/custom.blade.php' instead of
// 'resources/views/vendor/flash/notifications/success.blade.php'
flash()->success('message')->setView('custom');
```

The specified view name is relative to your app's view folder `resources/views`.

### Access notification values in a view

Notification views will have a `$notification` variable which is an instance of `\CodeZero\Flash\Notification`.

This gives you access to:

```blade
{{ $notification->message }}
{{ $notification->level }}
```

## 🔧 Create Your Own Custom Flash Class

If you don't want to use the built in notification levels and want to create your own, you can extend the `\CodeZero\Flash\BaseFlash` class.

```php
<?php

namespace App;

use CodeZero\Flash\BaseFlash;

class YourCustomFlash extends BaseFlash
{
    /**
     * Flash a notification.
     *
     * @param string $message
     *
     * @return \CodeZero\Flash\Notification
     */
    public function danger($message)
    {
        return $this->notification($message, 'danger');
    }
}
```

Then change the `flash` binding in the `register` method of your `app/Providers/AppServiceProvider`:

```php
public function register()
{
    $this->app->bind('flash', \App\YourCustomFlash::class);
}
```

## ⚙️ Publish Configuration File

```bash
php artisan vendor:publish --provider="CodeZero\Flash\FlashServiceProvider" --tag="config"
```

You will now find a `flash.php` file in the `config` folder.

## 🚧 Testing

```bash
composer test
```

## ☕️ Credits

- [Ivan Vermeyen](https://byterider.io)
- [All contributors](../../contributors)

## 🔓 Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## 📑 Changelog

A complete list of all notable changes to this package can be found on the
[releases page](https://github.com/codezero-be/laravel-flash/releases).

## 📜 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
