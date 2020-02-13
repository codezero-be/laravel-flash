<?php

if ( ! function_exists('flash')) {
    /**
     * Flash a message to the session.
     *
     * @param string|null $message
     * @param string $level
     *
     * @return \CodeZero\Flash\Flash
     */
    function flash($message = null, $level = 'info')
    {
        $flash = app('flash');

        if (is_null($message)) {
            return $flash;
        }

        return $flash->notification($message, $level);
    }
}
