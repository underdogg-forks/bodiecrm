{{-- Top Menu --}}

<aside id="top-menu" class="bg-black">
  <div id="top-menu-home-button" class="text-center">
    <i class="fa fa-bookmark"></i>
    <!--Tiny<i>CRM</i>-->
  </div>
  <div id="top-menu-links">
    <ul id="breadcrumb" class="inline-list">
      <!--<li {{ (Request::is('home') ? 'class=active' : '') }}><a href = "{{ url('home') }}">Home</a></li>-->

      @yield('breadcrumb')
    </ul>

    <div id="me" class="right">
      <button href="#" data-dropdown="user-dropdown-links" aria-controls="drop1" aria-expanded="false"
              class="button dropdown">
        <a class="th" href="{{ url('user') }}">
          @if ( is_null($user->profile_url) )
            <img src="{{ asset('img/default.png') }}">
          @else
            <img src="{{ asset('img/user/' . $user->id . '/' . $user->profile_url) }}"/>
          @endif
        </a>
        <a href="{{ url('user') }}">{{ $user->fullname }}</a>
      </button>
      <br>
      <ul id="user-dropdown-links" data-dropdown-content class="f-dropdown" aria-hidden="true">
        <li><a href="{{ url('user') }}">Your Profile</a></li>
        <li><a href="{{ url('user/' . $user->id . '/edit') }}">Edit Profile</a></li>
        <li><a href="{{ url('user/' . $user->id . '/change_password') }}">Change Password</a></li>
        <li><a href="{{ url('auth/logout') }}">Log Out</a></li>
      </ul>
    </div>
  </div>
</aside>