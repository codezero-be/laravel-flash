<?php

namespace CodeZero\Flash\Tests;

use CodeZero\Flash\Facades\Flash;
use CodeZero\Flash\Notification;
use Illuminate\Support\Collection;

class FlashTest extends TestCase
{
    /** @test */
    public function it_has_helper_methods_for_default_notification_levels()
    {
        Flash::info('Info message');
        Flash::success('Success message');
        Flash::warning('Warning message');
        Flash::error('Error message');

        $notifications = Flash::notifications();

        $this->assertInstanceOf(Collection::class, $notifications);
        $this->assertEquals(4, $notifications->count());
        $this->assertInstanceOf(Notification::class, $notifications[0]);
        $this->assertInstanceOf(Notification::class, $notifications[1]);
        $this->assertInstanceOf(Notification::class, $notifications[2]);
        $this->assertInstanceOf(Notification::class, $notifications[3]);
        $this->assertEquals('Info message', $notifications[0]->message);
        $this->assertEquals('info', $notifications[0]->level);
        $this->assertEquals('Success message', $notifications[1]->message);
        $this->assertEquals('success', $notifications[1]->level);
        $this->assertEquals('Warning message', $notifications[2]->message);
        $this->assertEquals('warning', $notifications[2]->level);
        $this->assertEquals('Error message', $notifications[3]->message);
        $this->assertEquals('error', $notifications[3]->level);
    }

    /** @test */
    public function it_returns_a_notification_instance()
    {
        $this->assertInstanceOf(Notification::class, Flash::info('Some message'));
        $this->assertInstanceOf(Notification::class, Flash::success('Some message'));
        $this->assertInstanceOf(Notification::class, Flash::warning('Some message'));
        $this->assertInstanceOf(Notification::class, Flash::error('Some message'));
    }
}
