@if (Session::has(config('flash.sessionKey')))
    @foreach (Session::get(config('flash.sessionKey')) as $flash)
        @if ($flash['overlay'] == true)
            @include('flash::modal', ['modalClass' => $flash['class'], 'title' => $flash['title'], 'body' => $flash['message']])
        @else
            <div class="alert alert-{{ $flash['class'] }}{{ $flash['dismissible'] ? ' alert-dismissible' : '' }}" role="alert">
                @if ($flash['dismissible'] == true)
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @endif
                {{ $flash['message'] }}
            </div>
        @endif
    @endforeach
@endif
