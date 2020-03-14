<!doctype html>
<html>
   <head>
      <title>My Login Page</title>
   </head>
   <body>
      {{ Form::open(array('url' => 'login')) }}
      <h1>Login</h1>
      <!-- if there are login errors, show them here -->
      <p>
         {{ $errors->first('username') }}
         {{ $errors->first('password') }}
      </p>
      <p>
         {{ Form::label('username', 'Username') }}
         {{ Form::text('username', Input::old('text'), array('placeholder' => 'myusername')) }}
      </p>
      <p>
         {{ Form::label('password', 'Password') }}
         {{ Form::password('password') }}
      </p>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <p>{{ Form::submit('Submit!') }}</p>
      {{ Form::close() }}
