@component('mail::message')
# {{$greeting}}
{{$body}}

@component('mail::button', ['url' => $actionUrl1])
{{$actionText1}}
@endcomponent
@component('mail::button', ['url' => 'placeholder'])
{{$actionText2}}
@endcomponent
{{$line}}
<br>
Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
    If you’re having trouble clicking the "{{ $actionText1 }}" button, copy and paste the URL below
    into your web browser: [{{ $actionUrl1 }}]({{ $actionUrl1 }})
@endcomponent
@endcomponent
