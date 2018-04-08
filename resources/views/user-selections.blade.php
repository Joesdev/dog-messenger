
<html>
    <head>
        <title>Test Page</title>
</head>
<body>

    @if($errors->any())
        <ul id="errors">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    {!! Form::open(['url' => '/user-selections', 'method' => 'post']) !!}
            {!! Form::label('email', 'email') !!}
            {!! Form::email('email') !!}
            <br>
            {!! Form::label('maxMiles', 'maxMiles') !!}
            {!! Form::text('maxMiles') !!}
            <br>
            {!! Form::label('zip', 'zip') !!}
            {!! Form::text('zip') !!}
            <br>
            {!! Form::label('breedName', 'breedName') !!}
            {!! Form::text('breedName') !!}
            <br>
            {!! Form::submit('submit') !!}
    {!! Form::close() !!}

</div>
</body>
</html>