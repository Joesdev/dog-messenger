@component('mail::message')
# {{$greeting}}
{{$body}}

@component('mail::button', ['url' => $actionUrl1])
{{$actionText}}
@endcomponent
{{$line}}
<br>
<br>
Thanks,<br>
{{ config('app.name') }}
<br>
@component('mail::panel')
    To Unsubscribe click <a href="{{$unsubLink}}">here</a>.
@endcomponent
<br>
@component('mail::subcopy')
    If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
    into your web browser: [{{ $actionUrl1 }}]({{ $actionUrl1 }})
@endcomponent
@endcomponent
