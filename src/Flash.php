<?php

namespace CodeZero\Flash;

class Flash extends BaseFlash
{
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
}
