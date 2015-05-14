<?php namespace spec\CodeZero\Flash\SessionStore;

use Illuminate\Session\Store;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LaravelSessionStoreSpec extends ObjectBehavior
{
    function let(Store $session)
    {
        $this->beConstructedWith($session);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Flash\SessionStore\LaravelSessionStore');
    }

    function it_checks_if_a_session_key_exists(Store $session)
    {
        $session->has('key')->shouldBeCalled()->willReturn(true);
        $this->has('key')->shouldReturn(true);
    }

    function it_gets_session_data(Store $session)
    {
        $session->get('key')->shouldBeCalled()->willReturn('value');
        $this->get('key')->shouldReturn('value');
    }

    function it_flashes_data_to_the_session(Store $session)
    {
        $session->flash('key', 'value')->shouldBeCalled();
        $this->flash('key', 'value');
    }
}
