# Flash

[![GitHub release](https://img.shields.io/github/release/codezero-be/flash.svg)]()
[![License](https://img.shields.io/packagist/l/codezero/flash.svg)]()
[![Build Status](https://img.shields.io/travis/codezero-be/flash.svg?branch=master)](https://travis-ci.org/codezero-be/flash)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/codezero-be/flash.svg)](https://scrutinizer-ci.com/g/codezero-be/flash)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/flash.svg)](https://packagist.org/packages/codezero/flash)

### Flash messages to the session with [Laravel 5](http://laravel.com/).

This package is based on the original version of [Laracasts](https://github.com/laracasts/flash), but adds a few extra features:

- Flash multiple messages in one request.
- Pass in a simple message or a key to look up in [Laravel's Translator](http://laravel.com/docs/5.0/localization).
- Provide an optional array of values to fill any placeholders on the localized message. 
- Enable or disable a `dismissible` option for alerts (defaults to `true`).

## Laravel 5 Installation

Install this package through Composer:

    composer require codezero/flash

Add a reference to `FlashServiceProvider` to the providers array in `config/app.php`:

    'providers' => [
        'CodeZero\Flash\FlashServiceProvider'
    ]

If you want to use the facade, then you can also add it there:

    'aliases' => [
        'Flash' => 'CodeZero\Flash\Facade\Flash'
    ]
    
## Usage

You can flash a message to the session in your controllers, before you redirect.

### 3 Ways to Flash...

You can use the facade...

    Flash::info('message');
    
... or the helper method...

    flash()->info('message');
    
... or you can inject `CodeZero\Flash\Flasher` in your controller and call it like this:

    $this->flash->info('message');

### Flash Types

    Flash::info('info message');
    Flash::success('success message');
    Flash::warning('warning message');
    Flash::error('error message');
    Flash::overlay('modal overlay message', 'Message Title');

Each type will flash specific data to the session to add the appropriate class to the view. 
These classes are defined in the configuration file. 

### Multiple Flashes

You can flash any number of messages of any type.
In your view, you can use `@foreach` to run through them (see the [view](https://github.com/codezero-be/flash/blob/master/src/views/message.blade.php)).
    
    Flash::success('success message');
    Flash::warning('warning message');

... or...

    Flash::success('success message')->warning('warning message');

### Dismissible Messages

By default an `alert-dismissible` class is added and a close button is shown. 
If you don't want this, you can pass `false` as the third argument. 
Obviously an overlay message is always dismissible and does not have this option. 

    Flash::success('success message', [], false); 

> Dismissing alerts require some javascript from [Bootstrap](http://getbootstrap.com/getting-started/), or your own.

### Localization

If you want to fetch a localized message from [Laravel's Translator](http://laravel.com/docs/5.0/localization), 
then you can pass in the translation key instead of a message. 
As a second parameter, you can optionally provide an array of placeholder values for the translated string.

    Flash::error('users.user_not_found', ['id' => $id]);
    Flash::overlay('users.user_not_found', 'users.title', ['id' => $id]);
    
This would look for an array key `user_not_found` and `title` in `resources/lang/en/users.php` (if your locale is `en`) 
and replace `:id` with the actual `$id`.

    'user_not_found' => 'There is no user with the ID of :id.'
    'title' => 'User :id Not Found'

### Show the Messages

In your master view, simply include a partial:

    @include('flash::message')
    
A full example with [Bootstrap](http://getbootstrap.com/):

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    </head>
    <body>
    
    <div class="container">
    
        @include('flash::message')

        <p>Welcome...</p>
        
    </div>
    
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    <!-- This is only necessary if you do Flash::overlay('...') -->
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    
    </body>
    </html>
    
### Customize the Messages

If you want to customize the templates you can publish the views:

    php artisan vendor:publish --provider="CodeZero\Flash\FlashServiceProvider" --tag="views"

> You will find the views in `resources/views/vendor/codezero/flash`.

If you want to change the class names or session key, publish the configuration file:

    php artisan vendor:publish --provider="CodeZero\Flash\FlashServiceProvider" --tag="config"

> You will find the configuration file at `config/flash.php`.

## Testing

    $ vendor/bin/phpspec run

## Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---
[![Analytics](https://ga-beacon.appspot.com/UA-58876018-1/codezero-be/flash)](https://github.com/igrigorik/ga-beacon)