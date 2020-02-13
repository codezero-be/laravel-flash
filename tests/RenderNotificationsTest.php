<?php

namespace CodeZero\Flash\Tests;

use CodeZero\Flash\Facades\Flash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class RenderNotificationsTest extends TestCase
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

        // Make sure HTML is not escaped.
        $response->assertSee('<');
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
}
