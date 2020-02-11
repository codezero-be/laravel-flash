<?php namespace CodeZero\Flash;

interface Flasher
{
    /**
     * Flash an info message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function info($message);

    /**
     * Flash a success message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function success($message);

    /**
     * Flash a warning message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function warning($message);

    /**
     * Flash an error message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function error($message);

    /**
     * Flash an overlay message.
     *
     * @param string $message
     * @param string $title
     *
     * @return $this
     */
    public function overlay($message, $title = 'Info');
}
