<?php

namespace CodeZero\Flash\Tests;

use CodeZero\Flash\Flash;
use CodeZero\Flash\Notification;

class HelperTest extends TestCase
{
    /** @test */
    public function it_returns_a_flash_instance()
    {
        $this->assertInstanceOf(Flash::class, flash());
    }

    /** @test */
    public function it_flashes_a_notification()
    {
        $notification = flash('message');

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertEquals('message', flash()->notifications()->first()->message);
        $this->assertEquals('default', flash()->notifications()->first()->level);
    }

    /** @test */
    public function it_flashes_a_notification_with_custom_level()
    {
        $notification = flash('message', 'custom');

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertEquals('message', flash()->notifications()->first()->message);
        $this->assertEquals('custom', flash()->notifications()->first()->level);
    }
}
