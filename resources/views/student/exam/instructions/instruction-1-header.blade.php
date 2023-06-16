<nav class="navbar lightGray-bg exam-nav">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item padding-left-0">
                <img src="{{ settings()->logo_photo }}" alt="CBEACCA">
            </a>
            <span class="navbar-burger burger" data-target="navbarMenuHeroB">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </div>
        
        <div id="navbarMenuHeroB" class="navbar-menu">
            
            <div class="navbar-start">
                <span class="navbar-item font-weight-700 font-size-22 padding-left-0 black-text">
                    Exam Summary
                </span>
            </div>
            
            
            <div class="navbar-end">
                <span class="navbar-item white-border-right orange-text font-weight-700 font-size-14">
                    {{ $course->name }} - {{ $course->alter_name }}
                </span>
                <span class="navbar-item">
                    <a href="{{ action('Dashboard@student') }}" class="orange-text font-weight-700 font-size-12 has-text-centered">
                        <img src="/public/img/settings/exit.png" alt="exit out of exam" class="image is-32x32">
                        <span>Exit</span>
                    </a>
                </span>
            </div>
        </div>
        
    </div>
</nav>