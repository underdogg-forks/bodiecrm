@extends('layouts.public')



@section('title')
  Login
@stop





@section('content')
  @if ( session('errors') )
    <div id="flash-message" data-alert class="alert-box alert text-center animated slideInDown">
      @foreach ( $errors->all() as $error )
        {{ $error }}
      @endforeach
    </div>
  @endif

  <div id="login">
    <div class="wrapper">
      <h3>Log Into Your Account</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id fringilla erat, a mattis enim. Aliquam at
        ultricies purus. Ut eu pellentesque ipsum. Vestibulum tristique dui eu est pharetra ullamcorper. Sed
        pellentesque, magna vel semper feugiat, urna nisi varius arcu, a egestas turpis risus quis lorem. Fusce pulvinar
        vulputate nunc eu luctus. Nunc tincidunt viverra ligula nec laoreet. Ut hendrerit, ante sed euismod dignissim,
        turpis libero sodales risus, eu consequat augue leo et risus.</p>
    </div>

    <div class="bg-gray">
      <div class="wrapper smaller row">
        <form method="POST" action="{{ url('auth/login') }}" class="row" data-abide>

          {!! csrf_field() !!}

          <div class="large-12 columns">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="you@email.com" required/>
            <small class="error">Email is required.</small>
          </div>

          <div class="large-12 columns">
            <label for="password">Password</label>
            <input type="password" name="password" required/>
            <small class="error">Password is required.</small>
          </div>

          <div class="large-12 columns">
            <input type="submit" value="Log In" class="button large radius success large-4 columns"/>

            <div class="register-from-login large-6 large-offset-1 columns left">
              Need an account? <a class="colored" href="{{ URL::to('auth/register') }}"/>Register!</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop