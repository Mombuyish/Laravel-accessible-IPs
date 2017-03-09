Laravel Accessible IPs
===

Required:

* laravel 5.3 or later.
* php 7 or later.

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

```php
'allowed' => [
        '127.0.0.1'
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

it will get same things.