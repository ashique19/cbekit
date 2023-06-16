<!--Header-->
<nav class="navbar lightGray-bg exam-nav">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item padding-left-0">
                <img src="{{ settings()->logo_photo }}" alt="CBEACCA">
            </a>
        </div>
        
        <div id="navbarMenuHeroB" class="navbar-menu">
            
            <div class="navbar-start">
                <span class="navbar-item white-border-right font-weight-700 font-size-12 padding-left-0 black-text">
                    <p>
                        Section <span show-section="" class="has-text-uppercase"></span>
                        <br>
                        <span>
                            Question <span show-q-number=""></span>
                        </span>
                    </p>
                </span>
            </div>
            
            
            <div class="navbar-end">
                <span class="navbar-item white-border-right font-weight-700 font-size-12">
                    <p class="text-center black-text">
                        Time Remaining
                        <br />
                        <span id="remaining-time" data-minutes="{{ $duration }}">00:00:00</span>
                    </p>
                </span>
                <span class="navbar-item white-border-right font-weight-700 font-size-12">
                    <p class="text-center">
                        <span class="gray-bg white-text font-weight-700 padding-left-40 padding-right-40 padding-top-5 padding-bottom-5 e-prog">
                            <span class="prog"></span>
                            <span class="e">Exam <span show-percentage=""></span>% Complete</span>
                        </span>
                        <br>
                        <span class="orange-text hover block margin-top-10" show-index>
                            <i class="fa fa-bar-chart font-size-16"></i> 
                            Exam Progress Details
                            <span class="fa-stack">
                                <i class="fa fa-circle fa-stack-2x black-text"></i>
                                <i class="fa fa-angle-down fa-stack-1x fa-inverse orange-text"></i>
                            </span>
                        </span>
                    </p>
                </span>
                <span class="navbar-item white-border-right orange-text font-weight-700 font-size-14">
                    {{ $course->name }} - {{ $course->alter_name }}
                </span>
                <span class="navbar-item">
                    <a href="#" id="exit" class="orange-text font-weight-700 font-size-12 has-text-centered">
                        <img src="/public/img/settings/exit.png" alt="exit out of exam" class="image is-32x32">
                        <span>Exit</span>
                    </a>
                </span>
            </div>
        </div>
        
    </div>
</nav>
<!--End Header-->