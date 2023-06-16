@extends('public.layouts.layout')
@section('title'){{ settings()->application_name }} | {{ settings()->application_slogan }}. @stop

@section('bodyClass')homepage @stop

@section('main')


<article class="columns is-multiline margin-0 padding-0">
    
    <section class="column is-12-desktop is-12-mobile margin-0 padding-0 home-bg">
        
        <h1 class="title">
        Practice
        <br>
        Computer Based Exams <span class="small">for</span> <br>
        ACCA
        <br>
        <span class="small">(FD FA1-FA, ACCA LW-FM)</span>
        <br>
        <br>
        <a href="{{ route('signup') }}" class="button is-info">Start for Free</a>
        </h1>

    </section>

    <section class="column is-12-desktop is-12-mobile">

        <div class="container margin-top-50 margin-bottom-50">
        
            <div class="columns is-multiline">
            
                <article class="column is-7-desktop is-12-mobile">
                    <h2 class="subtitle is-2 font-weight-100">What is CBE KIT ?</h2>

                    <p>
                        <b>CBE KIT</b> is an exam practice platform for students studying ACCA. It allows Students, Teachers and Institutes to plan and practice for ACCA exams.
                    </p>

                    <h3 class="subtitle is-4 margin-top-30">Core Features</h3>

                    <ul>
                        <li><span class="fa fa-angle-right blue-text margin-right-20 margin-bottom-20"></span>Looks and features are similar to real ACCA exams.</li>
                        <li><span class="fa fa-angle-right blue-text margin-right-20 margin-bottom-20"></span>Seperate layouts for FD and ACCA papers (just like real exam window).</li>
                        <li><span class="fa fa-angle-right blue-text margin-right-20 margin-bottom-20"></span>3 different dashboards for Students, Teachers & Institutes.</li>
                        <li><span class="fa fa-angle-right blue-text margin-right-20 margin-bottom-20"></span>Questions come with explanations.</li>
                        <li><span class="fa fa-angle-right blue-text margin-right-20 margin-bottom-20"></span>Teachers can mark, comment & reply on answers.</li>
                    </ul>

                    <p>
                        CBE KIT comes with hundreds of exam sessions with thousands of questions which are of exam standard, always up to date and mostly <b>freely accessible</b>.
                        <br>
                        <br>
                        <a href="{{ route('signup') }}" class="button is-info">Sign up now</a>
                    </p>
                </article>

                <aside class="column is-offset-1-desktop is-4-desktop is-12-mobile">
                    <img src="/public/img/backgrounds/bg2.png" alt="CBE KIT ALL TEMPLATE" class="image">
                </aside>


            </div>

        </div>

    </section>

    <section class="column is-12-desktop is-12-mobile">

        <div class="container margin-bottom-50">
        
            <div class="columns is-multiline">
            
                <article class="column is-12-desktop is-12-mobile">

                    <hr>

                    <h2 class="subtitle is-1 text-center margin-top-50">What's so GREAT about CBE KIT?</h2>

                    <p class="text-center">
                        <b>CBE KIT</b> is for Students, Teachers & Institutes.
                    </p>

                    <div class="columns is-multiline margin-top-20">

                        <section class="column is-4-desktop is-12-mobile padding-20">
                            <div class="card is-shadowless transparent-bg">
                            
                                <div class="card-image">
                                    <figure class="image max-width-200 is-centered">
                                        <img src="/public/img/backgrounds/student.jpg" alt="CBE KIT - Teachers" class="is-rounded">
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <div class="media">
                                        <div class="media-content">
                                            <p class="subtitle is-4 text-center">STUDENTS</p>
                                            <ul>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Practice in real exam like environment.
                                                </li>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Hundreds of exams, Thousands of questions, Unlimited practices.
                                                </li>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Learn from explanations of each question.
                                                </li>
                                                <li class="margin-bottom-30">
                                                    <span class="fa fa-angle-right blue-text"></span> Your answers are commented by qualified teachers.
                                                </li>
                                            </ul>
                                            <p class="text-center">
                                                <a href="{{ route('signup') }}" class="button is-info">Sign up</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>

                        <section class="column is-4-desktop is-12-mobile padding-20">
                            <div class="card is-shadowless transparent-bg">
                            
                                <div class="card-image">
                                    <figure class="image max-width-200 is-centered">
                                        <img src="/public/img/backgrounds/teacher.jpg" alt="CBE KIT - Teachers" class="is-rounded">
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <div class="media">
                                        <div class="media-content">
                                            <p class="subtitle is-4 text-center">TEACHERS</p>
                                            <ul>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Upload your own questions.
                                                </li>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Create your exam sessions with your uploaded questions or from CBE KIT question bank.
                                                </li>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Mark, comment on answers of your students.
                                                </li>
                                                <li class="margin-bottom-30">
                                                    <span class="fa fa-angle-right blue-text"></span> Communicate with CBE KIT Tech team about your custom requirements.
                                                </li>
                                            </ul>
                                            <p class="text-center">
                                                <a href="{{ route('signup') }}" class="button is-info">Sign up</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                    
                        <section class="column is-4-desktop is-12-mobile padding-20">
                            <div class="card is-shadowless transparent-bg">
                            
                                <div class="card-image">
                                    <figure class="image max-width-200 is-centered">
                                        <img src="/public/img/backgrounds/institute.jpg" alt="CBE KIT - Teachers" class="is-rounded">
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <div class="media">
                                        <div class="media-content">
                                            <p class="subtitle is-4 text-center">INSTITUTES</p>
                                            <ul>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Create your own student pool.
                                                </li>
                                                <li class="margin-bottom-10">
                                                    <span class="fa fa-angle-right blue-text"></span> Monitor progress of your students.
                                                </li>
                                                <li class="margin-bottom-30">
                                                    <span class="fa fa-angle-right blue-text"></span> Communicate with CBE KIT Tech team about your custom requirements.
                                                </li>
                                            </ul>
                                            <p class="text-center">
                                                <a href="{{ route('signup') }}" class="button is-info">Sign up</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>

                    </div>



                </article>

            </div>

        </div>

    </section>
    
    
</article>

@stop
