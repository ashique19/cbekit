@extends('student.exam.layout')
@section('title')Exam window - {{ settings()->application_name }} @stop

@section('main')

@include('student.exam.f-1-2-3-4-instruction')

@for( $i = 1; $i < count($questions) +1 ; $i++ )
<window id="{{ $i + 100 }}" class="hidden">
    
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
                    <span class="navbar-item white-border-right font-weight-700 font-size-12 padding-left-0 black-text">
                        <p>
                            Section {{ ucfirst( $questions[$i -1]['section'] ) }}
                            <br>
                            <br>
                            <span>
                                Question {{ $i }}
                            </span>
                        </p>
                    </span>
                </div>
                
                
                <div class="navbar-end">
                    <span class="navbar-item white-border-right font-weight-700 font-size-12">
                        <p class="text-center black-text">
                            Time Remaining
                            <br />
                            <br />
                            <span class="remaining-time">{{ $duration < 60 ? '00:'.$duration.':00' : floor( $duration/60 ).':'. round( ( $duration / 60 - floor( $duration / 60 ) ) * 100 ).':00' }}2:00:00</span>
                        </p>
                    </span>
                    <span class="navbar-item white-border-right font-weight-700 font-size-12">
                        <p class="text-center">
                            <span class="gray-bg white-text font-weight-700 padding-left-40 padding-right-40 padding-top-5 padding-bottom-5">
                                Exam 0% Complete
                            </span>
                            <br>
                            <br>
                            <span class="orange-text">
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
                    
                    <column class="column is-12 padding-left-50 padding-right-50">
                        
                        {!! $questions[$i-1]['exam_detail'] !!}
                        
                        
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
                    <li class="help">
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered show-help" href="{{ action('Exams@showHelp', $course->id) }}">
                            <img src="/public/img/settings/help.png" alt="Help" class="image is-32x32">
                            Help
                        </a>
                    </li>
                    <li class="flag margin-right-50">
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-flag="{{ $questions[$i-1]['id'] }}">
                            <img src="/public/img/settings/flag.png" alt="Flag" class="image is-32x32">
                            Flag
                        </a>
                    </li>
                    <li class="unflag hidden margin-right-50">
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-flag="{{ $questions[$i-1]['id'] }}">
                            <img src="/public/img/settings/unflag.png" alt="UnFlag" class="image is-32x32">
                            Remove Flag
                        </a>
                    </li>
                    @if( $i > 1 )
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered"  data-window_toggler="[{{ $i + 100 - 1 }},{{ $i + 100 }}]">
                            <img src="/public/img/settings/prev.png" alt="Previous" class="image is-32x32">
                            Previous
                        </a>
                    </li>
                    @endif
                    @if( $i < count( $questions ) )
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered"  data-window_toggler="[ {{ $i + 100 }} , {{ $i + 100 + 1 }} ]">
                            <img src="/public/img/settings/next.png" alt="Previous" class="image is-32x32">
                            Next
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>
@endfor

@stop
        