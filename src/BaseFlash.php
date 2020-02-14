<?php

namespace CodeZero\Flash;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class BaseFlash
{
    /**
     * Flash notifications session key.
     *
     * @var string
     */
    protected $sessionKey;

    /**
     * Create a new Flash instance.
     */
    public function __construct()
    {
        $this->sessionKey = Config::get('flash.sessionKey');
    }

    /**
     * Flash a notification.
     *
     * @param string $message
     * @param string|null $level
     *
     * @return \CodeZero\Flash\Notification
     */
    public function notification($message, $level = null)
    {
        $level = $level ?: 'default';
        $notification = new Notification($message, $level);

        $notifications = $this->getFlashedNotificationsFromSession();
        $notifications[] = $notification;

        Session::flash($this->sessionKey, $notifications);

        return $notification;
    }

    /**
     * Get flashed notifications.
     *
     * @return \Illuminate\Support\Collection
     */
    public function notifications()
    {
        return Collection::make($this->getFlashedNotificationsFromSession());
    }

    /**
     * Get flashed notifications from the session.
     *
     * @return array
     */
    protected function getFlashedNotificationsFromSession()
    {
        return Session::get($this->sessionKey, []);
    }
}
