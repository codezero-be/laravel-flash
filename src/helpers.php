<?php

if ( ! function_exists('flash')) {
    /**
     * Set flash messages.
     *
     * @param string $message
     * @param array $placeholders
     *
     * @return \CodeZero\Flash\Flash
     */
    function flash($message = null, array $placeholders = [])
    {
        $flash = app('flash');

        if ( ! is_null($message)) {
            return $flash->info($message, $placeholders);
        }

        return $flash;
    }
}
