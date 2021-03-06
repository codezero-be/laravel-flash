<?php

namespace CodeZero\Flash\Tests;

use CodeZero\Flash\Facades\Flash;
use CodeZero\Flash\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class BaseFlashTest extends TestCase
{
    /** @test */
    public function it_flashes_a_notification()
    {
        Flash::notification('Some message');

        $notifications = Flash::notifications();

        $this->assertInstanceOf(Collection::class, $notifications);
        $this->assertEquals(1, $notifications->count());
        $this->assertInstanceOf(Notification::class, $notifications->first());
        $this->assertEquals('Some message', $notifications->first()->message);
        $this->assertEquals('default', $notifications->first()->level);
    }

    /** @test */
    public function it_stores_notifications_in_the_session()
    {
        Flash::notification('Some message');

        $sessionNotifications = Session::get(Config::get('flash.sessionKey'));

        $this->assertIsArray($sessionNotifications);
        $this->assertInstanceOf(Notification::class, $sessionNotifications[0]);

        $flashNotifications = Flash::notifications();

        $this->assertInstanceOf(Collection::class, $flashNotifications);
        $this->assertInstanceOf(Notification::class, $flashNotifications[0]);

        $this->assertEquals($sessionNotifications[0], $flashNotifications[0]);
    }

    /** @test */
    public function it_accepts_a_custom_notification_level()
    {
        Flash::notification('Some message', 'custom');

        $notifications = Flash::notifications();

        $this->assertInstanceOf(Collection::class, $notifications);
        $this->assertEquals(1, $notifications->count());
        $this->assertInstanceOf(Notification::class, $notifications->first());
        $this->assertEquals('Some message', $notifications->first()->message);
        $this->assertEquals('custom', $notifications->first()->level);
    }

    /** @test */
    public function it_flashes_multiple_notifications()
    {
        Flash::notification('Info message', 'info');
        Flash::notification('Warning message', 'warning');

        $notifications = Flash::notifications();

        $this->assertInstanceOf(Collection::class, $notifications);
        $this->assertEquals(2, $notifications->count());
        $this->assertInstanceOf(Notification::class, $notifications[0]);
        $this->assertInstanceOf(Notification::class, $notifications[1]);
        $this->assertEquals('Info message', $notifications[0]->message);
        $this->assertEquals('info', $notifications[0]->level);
        $this->assertEquals('Warning message', $notifications[1]->message);
        $this->assertEquals('warning', $notifications[1]->level);
    }

    /** @test */
    public function it_returns_a_notification_instance()
    {
        $this->assertInstanceOf(Notification::class, Flash::notification('Some message'));
    }
}
