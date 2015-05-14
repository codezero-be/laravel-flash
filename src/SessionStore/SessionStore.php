<?php namespace CodeZero\Flash\SessionStore;

interface SessionStore
{
    /**
     * Check if a key exists in the session.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Get data from the session.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Flash data to the session.
     *
     * @param string $key
     * @param mixed $data
     *
     * @return void
     */
    public function flash($key, $data);
}
