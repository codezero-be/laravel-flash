<?php namespace CodeZero\Flash\SessionStore;

use Illuminate\Session\Store;

class LaravelSessionStore implements SessionStore
{
    /**
     * Laravel's Session Store.
     *
     * @var Store
     */
    private $session;

    /**
     * Create a new LaravelSessionStore instance.
     *
     * @param Store $session
     */
    function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Check if a key exists in the session.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->session->has($key);
    }

    /**
     * Get data from the session.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->session->get($key);
    }

    /**
     * Flash data to the session.
     *
     * @param string $key
     * @param mixed $data
     *
     * @return void
     */
    public function flash($key, $data)
    {
        $this->session->flash($key, $data);
    }
}
