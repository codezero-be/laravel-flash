<?php namespace spec\CodeZero\Flash;

use CodeZero\Flash\SessionStore\SessionStore;
use CodeZero\Flash\Translator\Translator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function let(SessionStore $session, Translator $translator)
    {
        $this->beConstructedWith($this->config, $session, $translator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Flash\Flash');
    }

    function it_flashes_a_message(Translator $translator, SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('message', '', $level, true, false);

            $translator->has('message')->shouldBeCalled()->willReturn(false);
            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
            $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

            $this->$level('message');
        }
    }

    function it_flashes_multiple_messages(Translator $translator, SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('message', '', $level, true, false);

            $translator->has('message')->shouldBeCalled()->willReturn(false);
            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(true);
            $session->get($this->config['sessionKey'])->shouldBeCalled()->willReturn([$flash]);
            $session->flash($this->config['sessionKey'], [$flash, $flash])->shouldBeCalled();

            $this->$level('message');
        }
    }

    function it_flashes_a_localized_message(Translator $translator, SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('translated message', '', $level, true, false);

            $translator->has('message')->shouldBeCalled()->willReturn(true);
            $translator->get('message', [])->shouldBeCalled()->willReturn('translated message');
            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
            $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

            $this->$level('message');
        }
    }

    function it_replaces_placeholders_in_localized_messages(Translator $translator, SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('translated message', '', $level, true, false);

            $translator->has('message')->shouldBeCalled()->willReturn(true);
            $translator->get('message', ['placeholder' => 'value'])->shouldBeCalled()->willReturn('translated message');
            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
            $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

            $this->$level('message', ['placeholder' => 'value']);
        }
    }

    function it_unsets_a_dismissible_option(Translator $translator, SessionStore $session)
    {
        foreach ($this->levels as $level) {
            $flash = $this->getFlash('message', '', $level, false, false);

            $translator->has('message')->shouldBeCalled()->willReturn(false);
            $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
            $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

            $this->$level('message', [], false);
        }
    }

    function it_flashes_an_overlay_message(Translator $translator, SessionStore $session)
    {
        $flash = $this->getFlash('message', 'Info', 'overlay', true, true);

        $translator->has('message')->shouldBeCalled()->willReturn(false);
        $translator->has('Info')->shouldBeCalled()->willReturn(false);
        $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
        $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

        $this->overlay('message');
    }

    function it_sets_a_custom_title_for_overlay_messages(Translator $translator, SessionStore $session)
    {
        $flash = $this->getFlash('message', 'custom title', 'overlay', true, true);

        $translator->has('message')->shouldBeCalled()->willReturn(false);
        $translator->has('custom title')->shouldBeCalled()->willReturn(false);
        $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
        $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

        $this->overlay('message', 'custom title');
    }

    function it_flashes_a_localized_overlay_message_and_title(Translator $translator, SessionStore $session)
    {
        $flash = $this->getFlash('translated message', 'translated title', 'overlay', true, true);

        $translator->has('message')->shouldBeCalled()->willReturn(true);
        $translator->get('message', [])->shouldBeCalled()->willReturn('translated message');
        $translator->has('title')->shouldBeCalled()->willReturn(true);
        $translator->get('title', [])->shouldBeCalled()->willReturn('translated title');
        $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
        $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

        $this->overlay('message', 'title');
    }

    function it_replaces_placeholders_in_localized_overlay_messages_and_titles(Translator $translator, SessionStore $session)
    {
        $flash = $this->getFlash('translated message', 'translated title', 'overlay', true, true);

        $translator->has('message')->shouldBeCalled()->willReturn(true);
        $translator->get('message', ['placeholder' => 'value'])->shouldBeCalled()->willReturn('translated message');
        $translator->has('title')->shouldBeCalled()->willReturn(true);
        $translator->get('title', ['placeholder' => 'value'])->shouldBeCalled()->willReturn('translated title');
        $session->has($this->config['sessionKey'])->shouldBeCalled()->willReturn(false);
        $session->flash($this->config['sessionKey'], [$flash])->shouldBeCalled();

        $this->overlay('message', 'title', ['placeholder' => 'value']);
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
