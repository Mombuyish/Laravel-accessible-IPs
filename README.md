<p align="center"><img src="http://i.imgur.com/8yhyKNl.png?1"></p>

<p align="center">
<a href="https://travis-ci.org/Mombuyish/Laravel-accessible-IPs"><img src="https://travis-ci.org/Mombuyish/Laravel-accessible-IPs.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/v/unstable.svg" alt="License"></a>
</p>

# Laravel Accessible IPs

> Accessible IPs for Laravel. Supported allowed ip and proxy server.

Required:
* laravel 5.3 or later.

# Installation

As others package, use composer install this package. For example:

``` bash
$ composer require yish/laravel-accessible-ip
```

Secondly, you need to register service provider in `config/app.php`, also, you can binding `AppServiceProvider` on register.

**Notice**
You must register provider after `Illuminate\Http\Request`.

``` php
    'providers' => [
    ...
    /*
     * Package Service Providers...
     */
    Mombuyish\AccessibleIP\AccessibleIPServiceProvider::class,
    ...
```

Thirdly, Going to `app/Http/Middleware/Kernel.php`, adding middleware

``` php
protected $routeMiddleware = [
        'access-ip' => \Mombuyish\AccessibleIP\Middleware\AccessibleIPAddress::class,
    ];
```

Fourthly, publish config.

``` bash
$ php artisan vendor:publish --provider="Mombuyish\AccessibleIP\AccessibleIPServiceProvider"
```

You can do configrate on config `access-ip.php`

🎉🎉**Supported CI/DR !!**🎉🎉

Including `127.0.0.1` inside, so you don't need add it.
```php
'allowed' => [
        '123.11.22.33',
        '123.11.0.0/32'
    ],
```

If you have proxies server on front, you should be place proxies:

🎉🎉**Supported CI/DR !!**🎉🎉

``` php
'proxies' => [
        env('PROXY_SERVER_IP'),
        '123.11.0.0/32'
    ],
```

Finally, you can use on routing middleware, for example:

``` php
Route::get('/', function () {
    return view('welcome');
})->middleware('access-ip');
```

or you can do this:

``` php
Route::group(['middleware' => ['access-ip']], function() {
    Route::get('/', function () {
        return view('welcome');
    });
});
```

# Exception
When you denied by middleware, you will get 403 Forbidden.
You can use `app/Exceptions/Handler.php` to change exception do something.

it will get same things.