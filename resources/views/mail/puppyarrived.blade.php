@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => $url1])
Button 1 Text
@endcomponent
@component('mail::button', ['url' => $url2])
Button 2 Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
