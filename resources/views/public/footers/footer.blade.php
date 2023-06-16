<!-- Hero footer: will stick at the bottom -->

<footer class="footer blue-bg padding-left-0 padding-0">
    <div class="container">

      <div class="columns is-vcentered">
        
        <div class="column ">
            <p class="small white-text">
              <a href="{{ action('StaticPageController@page', 'terms-of-service') }}" class="white-text">
                Terms & Conditions
              </a>
              <span class="white-text margin-left-5 margin-right-5">|</span>
              <a href="{{ action('StaticPageController@page', 'terms-of-service') }}" class="white-text">
                Privacy & Cookie policy
              </a>
              <span class="is-pulled-right">
                Copyright <i class="fa fa-copyright font-size-14 margin-top-2"></i> {{ date('Y') }} {{ settings()->application_name }}. All rights reserved.
              </span>
            </p>
        </div>
        
      </div>
    </div>
</footer>