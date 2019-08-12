# Laravel Accessible IPs

<svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path fill="#f4645f" d="M22 18v-2H8V4h2L7 1 4 4h2v2H2v2h4v8c0 1.1.9 2 2 2h8v2h-2l3 3 3-3h-2v-2h4zM10 8h6v6h2V8c0-1.1-.9-2-2-2h-6v2z"/></svg>

<p>
<a href="https://travis-ci.org/Mombuyish/Laravel-accessible-IPs"><img src="https://travis-ci.org/Mombuyish/Laravel-accessible-IPs.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/yish/laravel-accessible-ip"><img src="https://poser.pugx.org/yish/laravel-accessible-ip/v/unstable.svg" alt="License"></a>
</p>

Accessible IPs for Laravel. Supported allowed ip and proxy server.

## Requirement
#### laravel 5.1 - 5.4.

## Installation

Install via composer
``` bash
$ composer require yish/laravel-accessible-ip
```

You need to register service provider in `config/app.php`, also, you can binding `AppServiceProvider` on register.

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

Next, navigate to `app/Http/Middleware/Kernel.php`, adding middleware

``` php
protected $routeMiddleware = [
        'access-ip' => \Mombuyish\AccessibleIP\Middleware\AccessibleIPAddress::class,
    ];
```

Finally, publish the config.

``` bash
$ php artisan vendor:publish --provider="Mombuyish\AccessibleIP\AccessibleIPServiceProvider"
```

You can configrate on config `access-ip.php`

🎉🎉 **Supported CI/DR !!** 🎉🎉

Including `127.0.0.1` inside, so you don't need add it.
```php
'allowed' => [
        '123.11.22.33',
        '123.11.0.0/32'
    ],
```

If you have proxies server on front, you should be place proxies:

🎉🎉 **Supported CI/DR !!** 🎉🎉

``` php
'proxies' => [
        env('PROXY_SERVER_IP'),
        '123.11.0.0/32'
    ],
```

You can use on routing middleware, for example:

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
When you denied by middleware, you will get `403 Forbidden`.
You can use `app/Exceptions/Handler.php` to change exception do something.

It will get same things.
