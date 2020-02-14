<?php

namespace CodeZero\Flash;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Flash
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
     * Flash an info notification.
     *
     * @param string $message
     *
     * @return \CodeZero\Flash\Notification
     */
    public function info($message)
    {
        return $this->notification($message,'info');
    }

    /**
     * Flash a success notification.
     *
     * @param string $message
     *
     * @return \CodeZero\Flash\Notification
     */
    public function success($message)
    {
        return $this->notification($message,'success');
    }

    /**
     * Flash a warning notification.
     *
     * @param string $message
     *
     * @return \CodeZero\Flash\Notification
     */
    public function warning($message)
    {
        return $this->notification($message,'warning');
    }

    /**
     * Flash an error notification.
     *
     * @param string $message
     *
     * @return \CodeZero\Flash\Notification
     */
    public function error($message)
    {
        return $this->notification($message,'error');
    }

    /**
     * Flash a notification.
     *
     * @param string $message
     * @param string $level
     *
     * @return \CodeZero\Flash\Notification
     */
    public function notification($message, $level = 'default')
    {
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
