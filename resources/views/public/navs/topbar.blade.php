<!-- Hero header: will stick at the top -->
<div class="hero-head">
  <header class="nav" id="public-nav">
    <div class="container padding-0">
      <div class="nav-left">
        <a class="nav-item" href="{{ route('home') }}">
          <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}">
        </a>
      </div>
      
      <span class="nav-toggle" @click.prevent="togglePublicNav">
        <span></span>
        <span></span>
        <span></span>
      </span>
      
      <div class="nav-right nav-menu" class="activeNav">
        <a class="nav-item" href="{{ route('home') }}">
          Home
        </a>
        {{--
        <a class="nav-item" href="{{ action('StaticPageController@about') }}">
          About
        </a>
        --}}
        <a class="nav-item" href="{{ action('StaticPageController@pricing') }}">
          Pricing
        </a>
        <a class="nav-item" href="{{ action('StaticPageController@contact') }}">
          Contact
        </a>
        
        
        @if(auth()->user())
        
        @if( auth()->user()->role == 1 )
        <a class="nav-item" data-toggle="tooltip" data-placement="bottom" title="Media" href="{{ action('FileManager@index') }}" >
          <i class="fa fa-file"></i> <span class="is-hidden-tablet"> Media</span>
        </a>
        @endif
        
        @if( auth()->user()->role == 3 or auth()->user()->role == 4 )
        <a href="{{ action('Notifications@index') }}" class="nav-item" data-toggle="tooltip" data-placement="bottom" title="Notifications" >
          <i class="fa fa-question-circle"></i> <span class="is-hidden-tablet"> Notifications</span>
          @if( auth()->user()->notifications()->unread()->count() > 0 )
          <small class="red-text unread">{{ auth()->user()->notifications()->unread()->count() }}</small>
          @endif
        </a>
        @endif

        <a class="nav-item toggle-user-modal" data-toggle="tooltip" data-placement="bottom" title="User area" >
          <i class="fa fa-user-o fa-stack"></i> <span class="is-hidden-tablet"> User area</span>
        </a>
        
        <div class="modal" class="userModal" id="user-modal">
          <div class="modal-background"></div>
          <div class="modal-content">
            
            <div class="box text-center">

              <a href="{{ route('dashboard') }}" class="button is-info is-outlined margin-right-5 margin-bottom-5">Dashboard</a>
              <a href="{{ action('MyProfile@show') }}" class="button is-info is-outlined margin-right-5 margin-bottom-5">My Profile</a>
              <a href="{{ action('MyProfile@changePassword') }}" class="button is-info is-outlined margin-right-5 margin-bottom-5">Change Password</a>
              {{--<a href="{{ action('Clients@myPaymentHistory') }}" class="button is-info is-outlined margin-right-5 margin-bottom-5">Accounts</a>--}}
              <a href="{{ action('AccessController@logout') }}" class="button is-info is-outlined margin-right-5 margin-bottom-5">Log out</a>

            </div>
            
          </div>
          <button class="modal-close is-large toggle-user-modal"></button>
        </div>
        
        @else
        <a class="nav-item" href="{{ route('login') }}" data-toggle="tooltip" data-placement="bottom" title="Log in / Sign up">
          Log in / Sign up
        </a>
        @endif
        
      </div>

    </div>
  </header>
  
</div>