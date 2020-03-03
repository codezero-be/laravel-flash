<?php

namespace CodeZero\Flash\Tests;

use CodeZero\Flash\Facades\Flash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class NotificationTest extends TestCase
{
    /** @test */
    public function it_renders_all_notifications()
    {
        $this->withoutExceptionHandling();

        Route::get('flash', function () {
            Flash::notification('Custom level message', 'level');
            Flash::notification('Info message', 'info');

            return View::make('flash::notifications');
        });

        $response = $this->get('flash');

        $response->assertOk();
        $response->assertViewIs('flash::notifications');
        $response->assertSeeText('Custom level message');
        $response->assertSeeText('Info message');
    }

    /** @test */
    public function a_notification_can_be_rendered()
    {
        $this->withoutExceptionHandling();

        Route::get('flash', function () {
            return Flash::notification('Some message', 'level');
        });

        $response = $this->get('flash');

        $response->assertOk();
        $response->assertSeeText('Some message');
    }

    /** @test */
    public function you_can_set_a_custom_view_for_a_notification()
    {
        $this->withoutExceptionHandling();
        $this->setCustomViewPath();

        Route::get('flash', function () {
            Flash::notification('Some message')
                ->setView('custom');

            return View::make('flash::notifications');
        });

        $response = $this->get('flash');

        $response->assertOk();
        $response->assertSeeText('Custom view!');
        $response->assertSeeText('Some message');
    }

    /** @test */
    public function it_renders_html_unescaped()
    {
        $this->withoutExceptionHandling();
        $this->setCustomViewPath();

        Route::get('flash', function () {
            Flash::notification('Some message')
                ->setView('custom');

            return View::make('flash::notifications');
        });

        $response = $this->get('flash');

        $response->assertOk();
        $response->assertSee('<h1>Custom view!</h1>', false);
        $response->assertSee('<div>Some message</div>', false);
    }

    /**
     * Set a custom view path so Laravel will find our custom notification view.
     *
     * @return void
     */
    protected function setCustomViewPath()
    {
        Config::set('view.paths', [__DIR__ . '/Stubs/views']);
    }
}
