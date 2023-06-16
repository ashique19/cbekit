<nav class="navbar offwhite2-bg exam-nav">
    <div class="container" style="max-width: 100%;">

        <div class="navbar-brand">
            <a class="navbar-item padding-left-0">
                <img src="{{ settings()->logo_photo }}" alt="CBEACCA" width="80">
            </a>
            <span class="navbar-burger burger" data-target="navbarMenuHeroB">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </div>
        
        <div id="navbarMenuHeroB" class="navbar-menu">
            
            <div class="navbar-start">
                <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                    {{ $course->alter_name }} ({{ $course->name }})
                </span>
            </div>
            
            
        </div>
        
    </div>
</nav>