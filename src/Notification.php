<?php

namespace CodeZero\Flash;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\View;

class Notification implements Htmlable
{
    /**
     * The notification message.
     *
     * @var string
     */
    public $message;

    /**
     * The notification level.
     *
     * @var string
     */
    public $level;

    /**
     * Custom notification view.
     *
     * @var string
     */
    protected $view;

    /**
     * Create a new Notification instance.
     *
     * @param string $message
     * @param string $level
     */
    public function __construct($message, $level)
    {
        $this->message = $message;
        $this->level = $level;
    }

    /**
     * Set a custom view for this notification.
     *
     * @param string $view
     *
     * @return \CodeZero\Flash\Notification
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the view for this notification.
     *
     * @return \Illuminate\View\View
     */
    public function getView()
    {
        $view = strtolower($this->level);

        return View::first([
            $this->view,
            "flash::notifications.{$view}",
            "flash::notification",
        ], [
            'notification' => $this,
        ]);
    }

    /**
     * Get the HTML contents of the notification view.
     *
     * Implementing Htmlable enables displaying the HTML with
     * {{ $notification }} instead of {!! $notification !!}
     *
     * @return string
     * @throws \Throwable
     */
    public function toHtml()
    {
        return $this->getView()->render();
    }

    /**
     * Get the string contents of the notification view.
     *
     * @return string
     * @throws \Throwable
     */
    public function __toString()
    {
        return $this->getView()->render();
    }
}
