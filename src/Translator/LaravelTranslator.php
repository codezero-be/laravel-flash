<?php namespace CodeZero\Flash\Translator; 

use Illuminate\Translation\Translator as IlluminateTranslator;

class LaravelTranslator implements Translator
{
    /**
     * Laravel's Translator
     *
     * @var IlluminateTranslator
     */
    private $translator;

    /**
     * Create a new Translator instance.
     *
     * @param IlluminateTranslator $translator
     */
    public function __construct(IlluminateTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Check if there is a translated value for a given key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->translator->has($key);
    }

    /**
     * Get a translated value for the given key.
     *
     * @param string $key
     * @param array $placeholders
     *
     * @return string
     */
    public function get($key, array $placeholders = [])
    {
        return $this->translator->get($key, $placeholders);
    }
}
