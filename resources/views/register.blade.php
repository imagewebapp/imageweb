<!doctype html>
<html>
   <head>
      <title>My Registration Page</title>
   </head>
   <body>
      {{ Form::open(array('url' => 'register')) }}
      <h1>Register</h1>
      <!-- if there are login errors, show them here -->
      <p>
         {{ $errors->first('username') }}
         {{ $errors->first('email') }}
         {{ $errors->first('password') }}
      </p>
      <p>
         {{ Form::label('firstname', 'Firstname') }}
         {{ Form::text('firstname', Input::old('text'), array('placeholder' => '')) }}
      </p>
      <p>
         {{ Form::label('lastname', 'Lastname') }}
         {{ Form::text('lastname', Input::old('text'), array('placeholder' => '')) }}
      </p>
      <p>
         {{ Form::label('username', 'Username') }}
         {{ Form::text('username', Input::old('text'), array('placeholder' => '')) }}
      </p>
      <p>
         {{ Form::label('email', 'Email Address') }}
         {{ Form::text('email', Input::old('email'), array('placeholder' => 'user@somesite.com')) }}
      </p>
      <p>
         {{ Form::label('password', 'Password') }}
         {{ Form::password('password') }}
      </p>
      <p>
         {{ Form::label('confirmpassword', 'Confirm Password') }}
         {{ Form::password('confirmpassword') }}
      </p>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <p>{{ Form::submit('Submit!') }}</p>
      {{ Form::close() }}

