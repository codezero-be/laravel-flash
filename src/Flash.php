<?php namespace CodeZero\Flash;

use CodeZero\Flash\SessionStore\SessionStore;
use CodeZero\Flash\Translator\Translator;

class Flash implements Flasher
{
    /**
     * Session key under which the flash
     * notifications are stored.
     *
     * @var string
     */
    private $sessionKey;

    /**
     * Preferred class names that will be flashed.
     *
     * @var array
     */
    private $classNames;

    /**
     * Session Store.
     *
     * @var SessionStore
     */
    private $session;

    /**
     * Message Translator.
     *
     * @var Translator
     */
    private $translator;

    /**
     * Create a new Flash instance.
     *
     * @param array $config
     * @param SessionStore $session
     * @param Translator $translator
     */
    public function __construct(
        array $config,
        SessionStore $session,
        Translator $translator
    ) {
        $this->sessionKey = $config['sessionKey'];
        $this->classNames = $config['classNames'];
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * Flash an info message.
     *
     * @param string $message
     * @param array $placeholders
     * @param bool $dismissible
     *
     * @return $this
     */
    public function info($message, array $placeholders = [], $dismissible = true)
    {
        $this->message($message, null, $placeholders, 'info', $dismissible);

        return $this;
    }

    /**
     * Flash a success message.
     *
     * @param string $message
     * @param array $placeholders
     * @param bool $dismissible
     *
     * @return $this
     */
    public function success($message, array $placeholders = [], $dismissible = true)
    {
        $this->message($message, null, $placeholders, 'success', $dismissible);

        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param string $message
     * @param array $placeholders
     * @param bool $dismissible
     *
     * @return $this
     */
    public function warning($message, array $placeholders = [], $dismissible = true)
    {
        $this->message($message, null, $placeholders, 'warning', $dismissible);

        return $this;
    }

    /**
     * Flash an error message.
     *
     * @param string $message
     * @param array $placeholders
     * @param bool $dismissible
     *
     * @return $this
     */
    public function error($message, array $placeholders = [], $dismissible = true)
    {
        $this->message($message, null, $placeholders, 'error', $dismissible);

        return $this;
    }

    /**
     * Flash an overlay message.
     *
     * @param string $message
     * @param string $title
     * @param array $placeholders
     *
     * @return $this
     */
    public function overlay($message, $title = 'Info', array $placeholders = [])
    {
        $this->message($message, $title, $placeholders, 'overlay', true, true);

        return $this;
    }

    /**
     * Flash a message.
     *
     * @param string $message
     * @param string $title
     * @param array $placeholders
     * @param string $level
     * @param bool $dismissible
     * @param bool $overlay
     *
     * @return $this
     */
    private function message(
        $message,
        $title = '',
        array $placeholders = [],
        $level = 'info',
        $dismissible = true,
        $overlay = false
    ) {
        $message = $this->getTranslation($message, $placeholders);

        if ( ! empty($title)) {
            $title = $this->getTranslation($title, $placeholders);
        }

        $flash = [
            'message'     => $message,
            'title'       => $title,
            'level'       => $level,
            'dismissible' => $dismissible,
            'overlay'     => $overlay,
            'class'       => $this->classNames[$level]
        ];

        $messages = $this->getExistingFlashMessages();
        $messages[] = $flash;

        $this->session->flash($this->sessionKey, $messages);

        return $this;
    }

    /**
     * Get messages that have already been flashed.
     *
     * @return array
     */
    private function getExistingFlashMessages()
    {
        return $this->session->has($this->sessionKey)
            ? $this->session->get($this->sessionKey)
            : [];
    }

    /**
     * Get a translation for the message key
     * or return the original message.
     *
     * @param string $message
     * @param array $placeholders
     *
     * @return string
     */
    private function getTranslation($message, array $placeholders)
    {
        if ($this->translator->has($message)) {
            $message = $this->translator->get($message, $placeholders);
        }

        return $message;
    }
}
