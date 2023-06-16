
<window id="1">
    
    <!--Header-->
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
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-100 margin-bottom-100">
        <div class="container padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline margin-top-40 margin-bottom-40">
                
                    <div class="column is-4-desktop is-12-mobile">
                        <h2 class="title is-1 line-height-140">
                            Computer
                            <br>
                            Based
                            <br>
                            Exams
                        </h2>
                    </div>
                    
                    <div class="column is-8-desktop is-12-mobile">
                        
                        <h4 class="subtitle is-5 orange-text font-weight-700">
                            ACCA Qualification
                        </h4>
                        
                        <p class="black-text font-weight-600">
                            Exam Name:
                        </p>
                        <h4 class="padding-left-30 subtitle is-5 orange-text font-weight-700">
                            {{ $course->name }} - {{ $course->alter_name }}
                        </h4>
                        
                        <!--<p class="black-text font-weight-600">-->
                        <!--    Time Allowed:-->
                        <!--</p>-->
                        <!--<h4 class="padding-left-30 subtitle is-5 orange-text font-weight-700">-->
                        <!--    {{ $duration }} minutes-->
                        <!--</h4>-->
                        
                        <p class="black-text font-weight-600">
                            Pass Mark:
                        </p>
                        <h4 class="padding-left-30 subtitle is-5 orange-text font-weight-700">
                            {{ $course->pass_mark }}%
                        </h4>
                        
                        <p class="black-text font-weight-600">
                            Duration:
                        </p>
                        <h4 class="padding-left-30 subtitle is-5 orange-text font-weight-700">
                            @if( $duration < 60 ){{ $duration }} Minutes @else {{ floor( $duration / 60 ) }} Hours {{ $duration - floor( $duration / 60 ) * 60 }} Minutes @endif
                        </h4>
                        
                        <!--<p class="black-text font-weight-600 is-size-4">-->
                        <!--    This exam contains 2 sections:-->
                        <!--</p>-->
                        
                        <!--<p class="padding-left-30 black-text font-weight-600 margin-top-30">-->
                        <!--    Section A:-->
                        <!--</p>-->
                        
                        <!--<p class="padding-left-60 black-text font-weight-600">-->
                        <!--    @if( $course->id == 8 )-->
                        <!--    <b>46</b> questions, each worth 1 or 2 marks-->
                        <!--    <br>-->
                        <!--    <b>76</b> marks in total.-->
                        <!--    @else-->
                        <!--    <b>35</b> questions, each worth 2 marks-->
                        <!--    <br>-->
                        <!--    <b>70</b> marks in total.-->
                        <!--    @endif-->
                        <!--</p>-->
                        
                        <!--<p class="padding-left-30 black-text font-weight-600 margin-top-30">-->
                        <!--    Section B:-->
                        <!--</p>-->
                        <!--<p class="padding-left-60 black-text font-weight-600">-->
                        <!--    @if( $course->id == 8 )-->
                        <!--    <b>6</b> questions, each worth 4 marks-->
                        <!--    <br>-->
                        <!--    <b>24</b> marks in total.-->
                        <!--    @else-->
                        <!--    <b>3</b> questions, each worth 10 marks-->
                        <!--    <br>-->
                        <!--    <b>30</b> marks in total.-->
                        <!--    @endif-->
                        <!--</p>-->
                        
                        <p class="black-text font-weight-600 margin-top-30">
                            <img src="/public/img/settings/warning.png" width="22" /> All questions within each section are compulsory.
                        </p>
                        
                
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot gray-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[1,2]">
                            <img src="/public/img/settings/next.png" alt="Next" class="image is-32x32">
                            Next
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>


<window id="2" class="hidden">
    
    <!--Header-->
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
                        Instructions (1 of 3)
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
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-100 margin-bottom-100">
        <div class="container padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline margin-top-40 margin-bottom-40">
                    
                    <column class="column is-12 has-text-centered">
                        
                        <p class="font-weight-600 font-size-18 black-text margin-bottom-30">
                            <img src="/public/img/settings/warning.png" class="margin-right-5"></img> 
                            Please read <b>all</b> instructions. When you are finished click 'Next' to move to the next screen.
                        </p>
                        
                        <img src="/public/img/settings/suggestion-1.png" alt="suggestion">
                        
                    </column>
                
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot gray-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[1,2]">
                            <img src="/public/img/settings/prev.png" alt="Previous" class="image is-32x32">
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[2,3]">
                            <img src="/public/img/settings/next.png" alt="Next" class="image is-32x32">
                            Next
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>


<window id="3" class="hidden">
    
    <!--Header-->
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
                        Instructions (2 of 3)
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
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-100 margin-bottom-100">
        <div class="container padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline margin-top-40 margin-bottom-40">
                    
                    <column class="column is-12 has-text-centered">
                        
                        <img src="/public/img/settings/suggestion-2.png" alt="suggestion">
                        
                    </column>
                
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot gray-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[2,3]">
                            <img src="/public/img/settings/prev.png" alt="Previous" class="image is-32x32">
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[3,4]">
                            <img src="/public/img/settings/next.png" alt="Next" class="image is-32x32">
                            Next
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>


<window id="4" class="hidden">
    
    <!--Header-->
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
                        Instructions (3 of 3)
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
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-100 margin-bottom-100">
        <div class="container padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline margin-top-40 margin-bottom-40">
                    
                    <column class="column is-12 has-text-centered">
                        
                        <img src="/public/img/settings/suggestion-3.png" alt="suggestion">
                        
                    </column>
                
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot gray-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[3,4]">
                            <img src="/public/img/settings/prev.png" alt="Previous" class="image is-32x32">
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[4,5]">
                            <img src="/public/img/settings/next.png" alt="Next" class="image is-32x32">
                            Next
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>


<window id="5" class="hidden">
    
    <!--Header-->
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
                        Start Exam
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
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-100 margin-bottom-100">
        <div class="container padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline margin-top-40 margin-bottom-40">
                    
                    <column class="column is-12 has-text-centered">
                        
                        <p class="text-center black-text font-weight-600 margin-bottom-30">
                            Click the button below when you are ready to start the exam.
                        </p>
                        
                        <p class="text-center">
                            <button class="button red-bg black-border white-text is-small font-weight-600 start-exam" data-window_toggler="[5,101]">START EXAM</button>
                        </p>
                        
                        
                    </column>
                
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot gray-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[4,5]">
                            <img src="/public/img/settings/prev.png" alt="Previous" class="image is-32x32">
                            Previous
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>
