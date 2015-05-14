<?php namespace CodeZero\Flash;

interface Flasher
{
    /**
     * Flash an info message.
     *
     * @param string $message
     * @param array $placeholders
     *
     * @return $this
     */
    public function info($message, array $placeholders = []);

    /**
     * Flash a success message.
     *
     * @param string $message
     * @param array $placeholders
     *
     * @return $this
     */
    public function success($message, array $placeholders = []);

    /**
     * Flash a warning message.
     *
     * @param string $message
     * @param array $placeholders
     *
     * @return $this
     */
    public function warning($message, array $placeholders = []);

    /**
     * Flash an error message.
     *
     * @param string $message
     * @param array $placeholders
     *
     * @return $this
     */
    public function error($message, array $placeholders = []);

    /**
     * Flash an overlay message.
     *
     * @param string $message
     * @param string $title
     * @param array $placeholders
     *
     * @return $this
     */
    public function overlay($message, $title = 'Info', array $placeholders = []);
}
