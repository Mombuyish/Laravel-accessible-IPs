<?php

namespace Mombuyish\AccessibleIP\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mombuyish\AccessibleIP\AccessibleIPServiceProvider;
use Mockery as m;
use Mombuyish\AccessibleIP\Middleware\AccessibleIPAddress;

class IPCheckTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->register(AccessibleIPServiceProvider::class);

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        $this->app = $this->createApplication();
    }

    /**
     * @test
     * @group access
     */
    public function it_should_denied_ip_got_exception()
    {
        $this->app['config']->set('access-ip.proxies', ['192.168.0.0/32']);
        $this->app['config']->set('access-ip.allowed', ['127.0.0.1/32']);

        $instance = m::mock(Request::class);
        $this->app->instance(Request::class, $instance);
        $instance->shouldReceive('setTrustedProxies')->once();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $request = Request::create('/', 'GET', [], [], [], ['REMOTE_ADDR' => '123.21.33.44']);

        (new AccessibleIPAddress())->handle($request, function(){});
    }

    /**
     * @test
     * @group access
     */
    public function it_should_pass_all_given_all_values()
    {
        $this->app['config']->set('access-ip.proxies', ['127.0.0.1/32']);
        $this->app['config']->set('access-ip.allowed', ['127.0.0.1/32']);

        $instance = m::mock(Request::class);
        $this->app->instance(Request::class, $instance);
        $instance->shouldReceive('setTrustedProxies')->once();

        $request = Request::create('/', 'GET');

        (new AccessibleIPAddress())->handle($request, function(){});
    }

    /**
     * @test
     * @group access
     */
    public function it_should_not_pass_setTrustProxies()
    {
        $this->app['config']->set('access-ip.proxies', []);
        $this->app['config']->set('access-ip.allowed', ['127.0.0.1/32']);

        $request = Request::create('/', 'GET');

        (new AccessibleIPAddress())->handle($request, function(){});
    }
}
