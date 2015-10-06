@extends('layouts.public')




@section('title')
    Register
@stop





@section('content')

    @if ( ! $errors->isEmpty() )
        <div data-alert class = "alert-box alert row">
            <div class = "wrapper">

                @foreach ( $errors->getAll() as $error )
                    {{ $error }}
                @endforeach
            </div>
        </div>
    @endif

    <div id = "login">
        <div class = "wrapper">
            <h3>Register An Account</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id fringilla erat, a mattis enim. Aliquam at ultricies purus. Ut eu pellentesque ipsum. Vestibulum tristique dui eu est pharetra ullamcorper. Sed pellentesque, magna vel semper feugiat, urna nisi varius arcu, a egestas turpis risus quis lorem. Fusce pulvinar vulputate nunc eu luctus. Nunc tincidunt viverra ligula nec laoreet. Ut hendrerit, ante sed euismod dignissim, turpis libero sodales risus, eu consequat augue leo et risus.</p>
        </div>

        <div class = "bg-gray">
            <div class = "wrapper smaller row">
                <form method = "POST" action = "{{ url('auth/register') }}" class = "row" data-abide>

                    {!! csrf_field() !!}

                    <div class = "small-12 columns">
                        <label for = "first_name">First name</label>
                        <input type = "text" name = "first_name" required />
                        <small class = "error">First name is required.</small>
                    </div>

                    <div class = "small-12 columns">
                        <label for = "last_name">Last name</label>
                        <input type = "text" name = "last_name" required />
                        <small class = "error">Last name is required.</small>
                    </div>

                    <div class = "small-12 columns">
                        <label for = "email">Email</label>
                        <input type = "email" name = "email" placeholder = "you@email.com" required />
                        <small class = "error">Email is required.</small>
                    </div>

                    <div class = "small-12 columns">
                        <label for = "company">Company or Organization</label>
                        <input type = "text" name = "company" placeholder = "Your Company or Organization" />
                    </div>

                    <div class = "small-12 columns">
                        <label for = "password">Password <span class = "label right">Minimum 6 characters</span></label>
                        <input type = "password" name = "password" required />
                        <small class = "error">Password is required.</small>
                    </div>

                    <div class = "small-12 columns">
                        <label for = "password_confirmation">Confirm Password</label>
                        <input type = "password" name = "password_confirmation" required data-equalto = "password" />
                        <small class = "error">The password did not match.</small>
                    </div>

                    <div class = "small-12 columns">
                        <input type = "submit" value = "Register" class = "button large radius success large-4 columns" />
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop