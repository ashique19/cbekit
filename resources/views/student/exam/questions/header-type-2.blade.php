<nav class="navbar offwhite2-bg exam-nav">
    <div class="container">
        
        <div id="navbarMenuHeroB" class="navbar-menu">
            
            <div class="navbar-start">
                <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                    <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}" width="50" class="image"> &nbsp; {{ $course->alter_name }} ({{ $course->name }})
                </span>
            </div>
            
            <div class="navbar-end">
                <span class="navbar-item white-border-right font-weight-700 font-size-12">
                    <p class="text-center black-text">
                        Time Remaining:
                        <span id="remaining-time" data-minutes="{{ $duration }}">00:00:00</span>
                    </p>
                </span>
                <span class="navbar-item white-border-right">
                    <a href="#" class="black-text font-weight-700 font-size-12 has-text-centered">
                        <span current-q-number></span>/<span total-q-number></span> Questions
                    </a>
                </span>
                <span class="navbar-item">
                    <a href="#" class="black-text font-weight-700 font-size-12 has-text-centered" id="exit">
                        <span>Exit</span>
                    </a>
                </span>
            </div>
        </div>
        
    </div>
</nav>

<!--Secondary header-->
<nav class="navbar offwhite-bg secondary-nav">
        <div class="navbar-menu">
            
            <div class="navbar-start">
                <a href="#" class="navbar-item font-weight-700 padding-left-0 black-text" data-toggle="modal" data-target="#scratch-pad" >
                    <span class="scratch-pad-icon"></span> Scratch Pad
                </a>
                <a href="#" class="navbar-item font-weight-700 padding-left-0 black-text" id="highlight" >
                   <span class="scratch-pad-icon"></span> Highlight
                </a>
                <a href="#" class="navbar-item font-weight-700 padding-left-0 black-text" id="strike-through" >
                   <span class="scratch-pad-icon"></span> Strike Through
                </a>
                <a href="#" class="navbar-item font-weight-700 padding-left-0 black-text" data-toggle="modal" data-target="#calculator-modal">
                    <span class="calculator-icon"></span> Calculator
                </a>
            </div>
            
            <div class="navbar-end">
                <span class="navbar-item">
                    <a href="#" class="black-text font-weight-700 font-size-12 has-text-centered flag" >
                        <span class="flag-for-review-icon"></span><span class="padding-bottom-10"> Flag for Review</span>
                    </a>
                    <a href="#" class="black-text font-weight-700 font-size-12 has-text-centered unflag hidden" >
                        <span class="flagged-for-review-icon"></span><span class="padding-bottom-10"> Flag for Review</span>
                    </a>
                </span>
            </div>
        </div>
        
</nav>
<!--End: Secondary header-->

<article class="hero-body exam-screen offwhite-bg padding-0">
        <div class="container padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline margin-bottom-40">
                    
                    <column class="column is-12 padding-left-50 padding-right-50" id="q">