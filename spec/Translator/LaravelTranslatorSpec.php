<?php namespace spec\CodeZero\Flash\Translator;

use Illuminate\Translation\Translator as IlluminateTranslator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LaravelTranslatorSpec extends ObjectBehavior
{
    function let(IlluminateTranslator $translator)
    {
        $this->beConstructedWith($translator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeZero\Flash\Translator\LaravelTranslator');
    }

    function it_checks_if_a_translation_key_exists(IlluminateTranslator $translator)
    {
        $translator->has('key')->shouldBeCalled()->willReturn(true);
        $this->has('key')->shouldReturn(true);
    }

    function it_gets_a_translated_value(IlluminateTranslator $translator)
    {
        $translator->get('key', ['array'])->shouldBeCalled()->willReturn('value');
        $this->get('key', ['array'])->shouldReturn('value');
    }
}
