<?php namespace CodeZero\Flash;

use CodeZero\Flash\SessionStore\SessionStore;

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
     * Create a new Flash instance.
     *
     * @param array $config
     * @param SessionStore $session
     */
    public function __construct(
        array $config,
        SessionStore $session
    ) {
        $this->sessionKey = $config['sessionKey'];
        $this->classNames = $config['classNames'];
        $this->session = $session;
    }

    /**
     * Flash an info message.
     *
     * @param string $message
     * @param bool $dismissible
     *
     * @return $this
     */
    public function info($message, $dismissible = true)
    {
        $this->message($message, null, 'info', $dismissible);

        return $this;
    }

    /**
     * Flash a success message.
     *
     * @param string $message
     * @param bool $dismissible
     *
     * @return $this
     */
    public function success($message, $dismissible = true)
    {
        $this->message($message, null, 'success', $dismissible);

        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param string $message
     * @param bool $dismissible
     *
     * @return $this
     */
    public function warning($message, $dismissible = true)
    {
        $this->message($message, null,'warning', $dismissible);

        return $this;
    }

    /**
     * Flash an error message.
     *
     * @param string $message
     * @param bool $dismissible
     *
     * @return $this
     */
    public function error($message, $dismissible = true)
    {
        $this->message($message, null, 'error', $dismissible);

        return $this;
    }

    /**
     * Flash an overlay message.
     *
     * @param string $message
     * @param string $title
     *
     * @return $this
     */
    public function overlay($message, $title = 'Info')
    {
        $this->message($message, $title, 'overlay', true, true);

        return $this;
    }

    /**
     * Flash a message.
     *
     * @param string $message
     * @param string $title
     * @param string $level
     * @param bool $dismissible
     * @param bool $overlay
     *
     * @return $this
     */
    private function message(
        $message,
        $title = '',
        $level = 'info',
        $dismissible = true,
        $overlay = false
    ) {
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
}
