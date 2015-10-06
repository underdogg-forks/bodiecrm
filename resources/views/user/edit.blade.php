@extends('layouts.home')





@section('title')
    User
@stop




@section('subtitle')
    Edit Your Profile
@stop




@section('breadcrumb')
    <li><a href = "{{ url('user') }}">You</a></li>
    <li class = "active"><a href = "{{ url('user/' . $user->id . '/edit') }}">Edit Profile</a></li>
@stop






@include('partials.header')





@section('content')
    <div id = "user_profile_edit" class = "row">
        <div class = "small-12 columns">
            <div id = "user_profile_avatar" class = "row" data-equalizer>
                
                <div id = "user_profile_avatar_image" class = "small-2 columns" data-equalizer-watch>
                    @if ( is_null($user->profile_url) )
                        <img src = "{{ asset('img/default.png') }}" class = "th" />
                    @else
                        <img src = "{{ asset('img/user/' . $user->id . '/' . $user->profile_url) }}" class = "th" />
                    @endif
                </div>

                <form id = "upload-avatar" action = "{{ url('user/' . $user->id . '/upload_avatar') }}" class = "dropzone small-5 columns text-center" data-equalizer-watch>
                    {!! csrf_field() !!}
                </form>
            </div>

            <script>
                $(function() {
                    Dropzone.options.uploadAvatar = {
                        paramName:          'file',
                        maxFilesize:        2,
                        dictDefaultMessage: 'Drop an image here to upload (max 2MB).<br>The following extensions are allowed: jpeg, png, bmp, gif.',
                        acceptedFiles:      'image/*',
                        success: function(file, url) {
                            $('.dz-message, .dz-preview.dz-complete, #flash-message').remove();

                            $('section#home').prepend('<div id = "flash-message" data-alert class = "alert-box success text-center animated slideInDown">Profile image updated</div>');

                            $('#user_profile_avatar_image').html('<img src = "' + url + '" />');
                        }
                    };
                });
            </script>

            <form method = "POST" action = "{{ url('user/' . $user->id) }}" class = "row" data-abide>

                {!! csrf_field() !!}

                <input type = "hidden" name = "_method" value = "PUT" />

                <div class = "small-12 columns">
                    <label for = "first_name">First Name</label>
                    <input type = "text" name = "first_name" value = "{{ $user->first_name }}" required />
                    <small class = "error">First name is required.</small>
                </div>

                <div class = "small-12 columns">
                    <label for = "last_name">Last Name</label>
                    <input type = "text" name = "last_name" value = "{{ $user->last_name }}" required />
                    <small class = "error">Last name is required.</small>
                </div>

                <div class = "small-12 columns">
                    <label for = "company">Company</label>
                    <input type = "text" name = "company" value = "{{ $user->company }}" />
                </div>

                <div class = "small-12 columns">
                    <label for = "email">Email</label>
                    <input type = "email" name = "email" value = "{{ $user->email }}" required />
                    <small class = "error">Email is required.</small>
                </div>

                <div class = "small-12 columns">
                    <label for = "timezone">Timezone</label>
                    {!! Timezone::selectForm($user->timezone, 'Select a timezone', ['name' => 'timezone']) !!}
                </div>

                <div class = "small-12 columns">
                    <input type = "submit" value = "Update" class = "button large radius success large-4 columns" />
                </div>
            </form>
        </div>
    </div>
@stop