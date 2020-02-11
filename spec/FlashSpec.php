<?php namespace spec\CodeZero\Flash;

use CodeZero\Flash\SessionStore\SessionStore;
use PhpSpec\ObjectBehavior;

class FlashSpec extends ObjectBehavior
{
    private $config = [
        'sessionKey' => 'flash_notifications',
        'classNames' => [
            'info'    => 'info',
            'success' => 'success',
            'warning' => 'warning',
            'error'   => 'danger',
            'overlay' => ''
        ],
        'closeButtonText' => 'Close'
    ];

    private $levels = ['info', 'success', 'warning', 'error'];

    function let(SessionStore $session)
    {
        $this->beConstructedWith($this->config, $session);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Flash\Flash');
    }

    function it_flashes_a_message(SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('message', '', $level, true, false);

            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
            $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

            $this->$level('message');
        }
    }

    function it_flashes_multiple_messages(SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('message', '', $level, true, false);

            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(true);
            $session->get($this->config['sessionKey'])->shouldBeCalled()->willReturn([$flash]);
            $session->flash($this->config['sessionKey'], [$flash, $flash])->shouldBeCalled();

            $this->$level('message');
        }
    }

    function it_unsets_a_dismissible_option(SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('message', '', $level, false, false);

            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
            $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

            $this->$level('message', [], false);
        }
    }

    function it_flashes_an_overlay_message(SessionStore $session)
    {
        $flash = $this->getFlash('message', 'Info', 'overlay', true, true);

        $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
        $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

        $this->overlay('message');
    }

    function it_sets_a_custom_title_for_overlay_messages(SessionStore $session)
    {
        $flash = $this->getFlash('message', 'custom title', 'overlay', true, true);

        $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
        $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

        $this->overlay('message', 'custom title');
    }

    private function getFlash($message, $title, $level, $dismissible, $overlay)
    {
        return [
            'message' => $message,
            'title' => $title,
            'level' => $level,
            'dismissible' => $dismissible,
            'overlay' => $overlay,
            'class' => $this->config['classNames'][$level]
        ];
    }
}
