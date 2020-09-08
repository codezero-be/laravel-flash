<?php

if ( ! function_exists('flash')) {
    /**
     * Flash a message to the session.
     *
     * @param string|null $message
     * @param string|null $level
     *
     * @return \CodeZero\Flash\Flash
     */
    function flash($message = null, $level = null)
    {
        $flash = app('flash');

        if ($message === null) {
            return $flash;
        }

        return $flash->notification($message, $level);
    }
}
