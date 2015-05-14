<?php namespace CodeZero\Flash\Translator;

interface Translator
{
    /**
     * Check if there is a translated value for a given key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Get a translated value for the given key.
     *
     * @param string $key
     * @param array $placeholders
     *
     * @return string
     */
    public function get($key, array $placeholders = []);
}
