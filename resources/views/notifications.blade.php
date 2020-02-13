@foreach(flash()->notifications() as $notification)
    {{ $notification }}
@endforeach
