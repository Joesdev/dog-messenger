@component('mail::message')
# {{$greeting}}
{{$body}}

@component('mail::button', ['url' => 'placeholder'])
Button 1 Text
@endcomponent
@component('mail::button', ['url' => 'placeholder'])
Button 2 Text
@endcomponent
{{$line}}
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
