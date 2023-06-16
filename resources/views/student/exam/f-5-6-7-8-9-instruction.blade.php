
<window id="1">
    
    <!--Header-->
    <nav class="navbar offwhite2-bg exam-nav">
        <div class="container">
            
            <div id="navbarMenuHeroB" class="navbar-menu">
                
                <div class="navbar-start">
                    <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                        {{ $course->alter_name }} ({{ $course->name }})
                    </span>
                </div>
                
                
            </div>
            
        </div>
    </nav>
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-30 margin-bottom-100">
        <div class=" padding-5">
            
            <div class="exam-page">
                
                <section class="columns is-multiline argin-bottom-40">
                
                    <div class="column is-12-desktop is-12-mobile">
                        <img src="{{ settings()->logo_photo }}" alt="ACCA - Think Ahead" class="image">
                    </div>
                    
                    <div class="column is-12-desktop is-12-mobile font-size-16">
                        
                        <p class="font-size-20 font-weight-700">Introduction</p>
                        
                        <p>
                            
                            The specimen exam indicates how the live exam will be structured and assessed, and the likely style and range of questions that could be asked.
                            <br>
                            You should use the specimen exam to become familiar with the question types and the features and functionality contained within the live exam.
                            <br>
                            The specimen exam is reflective of the live exam experience but has some differences:
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    There is no timer in the specimen exam however the live exam will have a time limit.
                                </li>
                                <li class="margin-top-10">
                                    The live exam is worth a total of 110 marks, 10 marks of which are for questions that do not count towards your final result and are included for quality assurance purposes. This specimen exam is worth a total of 100 marks, reflecting the element of the live exam on which your result will be based.
                                </li>
                                <li class="margin-top-10">
                                    In the live exam your answers to the constructed response questions will be expert-marked. In the specimen exam you should use the solution material provided to assess your performance.
                                </li>
                                <li class="margin-top-10">
                                    Solution material is provided for each question in the specimen exam and can be accessed by selecting <img src="/public/img/settings/explain-exam-icon.png"></img> from the top toolbar.
                                </li>
                                <li class="margin-top-10">
                                    If you want to sit the specimen exam in exam style conditions you should answer the questions presented within a 3 hour time period without reviewing the solution material.
                                </li>
                                <li class="margin-top-10">
                                    In the live exam you will be able to highlight and strikethrough text in the question scenario (this feature is not currently available in the specimen exam).
                                </li>
                            </ul>
                            
                        </p>
                
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot offwhite2-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[1,2]">
                            Next
                            <span class="next-icon"></span>
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
    <nav class="navbar offwhite2-bg exam-nav">
        <div class="container">
            
            <div id="navbarMenuHeroB" class="navbar-menu">
                
                <div class="navbar-start">
                    <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                        <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}" width="50" class="image"> &nbsp; {{ $course->alter_name }} ({{ $course->name }})
                    </span>
                </div>
                
                
            </div>
            
        </div>
    </nav>
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-30 margin-bottom-100">
        <div class="padding-5">
            
            <div class="exam-page padding-bottom-40">
                
                <section class="columns is-multiline margin-bottom-40 padding-bottom-40">
                
                    <div class="column is-12-desktop is-12-mobile font-size-16">
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Instructions (1 of 4)</p>
                        
                        <p>
                            
                            The instructions displayed below are representative of those displayed in the live exam.  Where there are differences between the specimen and live exam these are explained.
                            <br>
                            <span class="font-size-18 font-weight-700 margin-top-10">General Instructions</span>
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    In the specimen exam, the instruction screens are not timed however in the live exam they will be available for a maximum of 10 minutes prior to the exam starting.
                                </li>
                                <li class="margin-top-10">
                                    In the live exam, the stated exam time will automatically start once the 10 minute period has passed (or earlier if you choose to start the exam within the 10 minute period).
                                </li>
                                <li class="margin-top-10">
                                    A copy of the instruction screens can be accessed at any time during the exam by selecting <img src="/public/img/settings/help-and-formula-sheet.png"></img>
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Answering and Navigating</p>
                        
                        <p>
                            
                            The instructions displayed below are representative of those displayed in the live exam.  Where there are differences between the specimen and live exam these are explained.
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    Please read each question carefully.
                                </li>
                                <li class="margin-top-10">
                                    The question number you are viewing is displayed in the top display bar.  You can hide or restore this display by selecting <img src="/public/img/settings/instruction-toggler-icon.png" alt="">
                                </li>
                                <li class="margin-top-10">
                                    You can navigate between screens by selecting <img src="/public/img/settings/next-icon.png"></img>  or <img src="/public/img/settings/prev-icon.png"></img>, or by clicking on a question number from the Navigator or Item Review screens.
                                </li>
                                <li>
                                    A warning message will display to remind you that you cannot navigate away from a question if you have not viewed all of the question content. Ensure that you use all scrollbars and/or open any on-screen exhibits before navigating from each question.
                                </li>
                                <li>
                                    Some questions have the scenario and answer area divided by either a horizontal or vertical splitter bar. You can move this splitter bar to see more or less of the scenario or answer area.
                                </li>
                                <li>
                                    Please ensure you provide an answer for all elements of each question.
                                </li>
                                <li>
                                    You can revisit questions and change your answers at any time during the exam.
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Explain Answer</p>
                        
                        <p>
                            
                            The instructions displayed below are representative of those displayed in the live exam.  Where there are differences between the specimen and live exam these are explained.
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    In the specimen exam, solution material is provided for each question and can be accessed by selecting <img src="/public/img/settings/explain-exam-icon.png"></img>
                                </li>
                                <li class="margin-top-10">
                                    You can access the solution material as you progress through the specimen exam (on a question by question basis) or after the exam.
                                </li>
                            </ul>
                            
                        </p>
                
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot offwhite2-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[1,2]">
                            <span class="prev-icon"></span>
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[2,3]">
                            Next
                            <span class="next-icon"></span>
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
    <nav class="navbar offwhite2-bg exam-nav">
        <div class="container">
            
            <div id="navbarMenuHeroB" class="navbar-menu">
                
                <div class="navbar-start">
                    <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                        <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}" width="50" class="image"> &nbsp; {{ $course->alter_name }} ({{ $course->name }})
                    </span>
                </div>
                
                
            </div>
            
        </div>
    </nav>
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-30 margin-bottom-100">
        <div class="padding-5">
            
            <div class="exam-page padding-bottom-40">
                
                <section class="columns is-multiline margin-bottom-40 padding-bottom-40">
                
                    <div class="column is-12-desktop is-12-mobile font-size-16">
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Instructions (2 of 4)</p>
                        
                        <p>
                            
                            <span class="font-size-18 font-weight-700 margin-top-10">Flag for Review</span>
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    If you wish to revisit/review a question later in the exam, click <img src="/public/img/settings/flag-for-review.png"></img>
                                </li>
                                <li class="margin-top-10">
                                    Click the button again if you no longer wish to revisit/review the question later in the exam.
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Help/Formulae Sheet</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    Click <img src="/public/img/settings/help-and-formula-sheet.png"></img> to access:
                                    
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            The formulae sheet relevant to this exam.
                                        </li>
                                        <li class="margin-top-10">
                                            Help and guidance on constructed response questions (available in Section C only).
                                        </li>
                                        <li class="margin-top-10">
                                            A copy of these exam instructions.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Calculator</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    You have the option to use the on-screen standard or scientific calculators by selecting <img src="/public/img/settings/calculator.png"></img>
                                </li>
                                <li class="margin-top-10">
                                    Note that in the live exam you are also permitted to use your own calculator providing it does not have the facility to store or display text.
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Workings/Scratch Pad</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    You may use an on-screen Scratch Pad to make notes/workings by selecting <img src="/public/img/settings/scratch-pad.png"></img>
                                </li>
                                <li class="margin-top-10">
                                    The Scratch Pad retains all notes/workings entered for all questions and these are available for the duration of the exam. They will not be submitted for marking after your live exam.
                                </li>
                                <li class="margin-top-10">
                                    You will also be provided with paper for notes/workings for your live exam, should you prefer to use it. This will not be submitted for marking.  It will be collected at the end of the exam and must not be removed from the exam room.
                                </li>
                                
                                <p class="font-size-20 font-weight-700 margin-bottom-10">Important:</p>
                                
                                <ul class="padding-left-40" style="list-style: disc;">
                                    <li class="margin-top-10">
                                        The notes/workings entered onto the Scratch Pad or your workings paper during the live exam will not be marked.
                                    </li>
                                    <li class="margin-top-10">
                                        If you want the marker to see any notes/workings for questions in Section C of the live exam you must show them within the spreadsheet or word processing answer areas.
                                    </li>
                                </ul>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Insert Symbol</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    You can add a selection of currency symbols to your word processing or spreadsheet answers in Section C of the exam by selecting <img src="/public/img/settings/symbol.png"></img> on the top toolbar.
                                </li>
                            </ul>
                            
                        </p>
                
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot offwhite2-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[2,3]">
                            <span class="prev-icon"></span>
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[3,4]">
                            Next
                            <span class="next-icon"></span>
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
    <nav class="navbar offwhite2-bg exam-nav">
        <div class="container">
            
            <div id="navbarMenuHeroB" class="navbar-menu">
                
                <div class="navbar-start">
                    <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                        <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}" width="50" class="image"> &nbsp; {{ $course->alter_name }} ({{ $course->name }})
                    </span>
                </div>
                
                
            </div>
            
        </div>
    </nav>
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-30 margin-bottom-100">
        <div class="padding-5">
            
            <div class="exam-page padding-bottom-40">
                
                <section class="columns is-multiline margin-bottom-40 padding-bottom-40">
                
                    <div class="column is-12-desktop is-12-mobile font-size-16">
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Instructions (3 of 4)</p>
                        
                        <p>
                            
                            <span class="font-size-18 font-weight-700 margin-top-10">Navigator Screen</span>
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    Navigator can be accessed at any time during the exam by selecting <img src="/public/img/settings/navigator.png"></img>
                                </li>
                                <li class="margin-top-10">
                                    This screen allows you to jump to any question number in the exam.
                                </li>
                                <li class="margin-top-10">
                                    It also allows you to see the status of questions and whether they have been viewed, are complete or incomplete, or have been flagged for review.
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Reviewing the Specimen Exam</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            You can review your specimen exam once you have attempted any, or all, of the questions.
                                        </li>
                                        <li class="margin-top-10">
                                            To do this:
                                            <ul class="padding-left-40" style="list-style: disc;">
                                                <li class="margin-top-10">
                                                    Navigate to the last question in the exam.
                                                </li>
                                                <li class="margin-top-10">
                                                    Click the Next button.
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="margin-top-10">
                                            This takes you to the Item Review screen.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Item Review Screen</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    This screen gives you an opportunity to see the flag and completion status of all questions before you exit the exam.
                                </li>
                                <li class="margin-top-10">
                                    In the live exam this screen will indicate whether the question is complete or incomplete. In the specimen exam, it will show the following:
                                </li>
                                <li class="margin-top-10">
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            Section A (OTs) & Section B (OT cases) - automatically marked questions
                                            <ul class="padding-left-40" style="list-style: disc;">
                                                <li class="margin-top-10">
                                                    Unseen – you have not yet viewed the question.
                                                </li>
                                                <li class="margin-top-10">
                                                    Blank - you have attempted the question and the answer is correct.
                                                </li>
                                                <li class="margin-top-10">
                                                    Incorrect – you have attempted the question and the answer is incorrect, or you have viewed the question but not provided an answer.
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            Section C (constructed response questions)
                                            <ul class="padding-left-40" style="list-style: disc;">
                                                <li class="margin-top-10">
                                                    Unseen – you have not yet viewed the question.
                                                </li>
                                                <li class="margin-top-10">
                                                    Blank – you have viewed the question.
                                                </li>
                                                <li class="margin-top-10">
                                                    There will be no indication on whether these questions have been answered or whether the answers are correct or incorrect.  You should refer to the solution material for guidance to assess your own performance.
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                
                            </ul>
                            
                        </p>
                        
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot offwhite-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="font-weight-700 font-size-12 has-text-centered" data-window_toggler="[3,4]">
                            <span class="prev-icon"></span>
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="font-weight-700 font-size-12 has-text-centered" data-window_toggler="[4,5]">
                            Next
                            <span class="next-icon"></span>
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
    <nav class="navbar offwhite2-bg exam-nav">
        <div class="container">
            
            <div id="navbarMenuHeroB" class="navbar-menu">
                
                <div class="navbar-start">
                    <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                        <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}" width="50" class="image"> &nbsp; {{ $course->alter_name }} ({{ $course->name }})
                    </span>
                </div>
                
                
            </div>
            
        </div>
    </nav>
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-30 margin-bottom-100">
        <div class="padding-5">
            
            <div class="exam-page padding-bottom-40">
                
                <section class="columns is-multiline margin-bottom-40 padding-bottom-40">
                
                    <div class="column is-12-desktop is-12-mobile font-size-16">
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Instructions (4 of 4)</p>
                        
                        <p>
                            
                            <span class="font-size-18 font-weight-700 margin-top-10">Revisiting Questions</span>
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    You can select individual questions you wish to revisit, or quickly access groups of questions from the Item Review screen.
                                </li>
                                <li class="margin-top-10">
                                    During the item review period Navigator is not available however you can navigate to questions by selecting <img src="/public/img/settings/next-icon.png"></img>, <img src="/public/img/settings/prev-icon.png"></img> or <img src="/public/img/settings/review-screen.png"></img>
                                </li>
                                <li class="margin-top-10">
                                    When reviewing questions you can change your answer and click <img src="/public/img/settings/review-screen.png"></img> to view any updated status on the Item Review screen.
                                </li>
                                <li class="margin-top-10">
                                    The solution material will also be available to you during this review.
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Ending the Exam</p>
                        
                        <p>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <li class="margin-top-10">
                                    
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            Once you have completed your item review and wish to finally end the exam click <img src="/public/img/settings/end-exam.png"></img>
                                        </li>
                                        <li class="margin-top-10">
                                            Once you end the exam, you cannot revisit any questions.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-20 margin-bottom-10 margin-top-40">Select <span class="font-weight-700">Next</span> to move to the Exam Summary screen. </p>
                        
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot offwhite2-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[4,5]">
                            <span class="prev-icon"></span>
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[5,6]">
                            Next
                            <span class="next-icon"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>


<window id="6" class="hidden">
    
    <!--Header-->
    <nav class="navbar offwhite2-bg exam-nav">
        <div class="container">
            
            <div id="navbarMenuHeroB" class="navbar-menu">
                
                <div class="navbar-start">
                    <span class="navbar-item font-weight-700 font-size-14 padding-left-0 black-text">
                        <img src="{{ settings()->logo_photo }}" alt="{{ settings()->application_name }}" width="50" class="image"> &nbsp; {{ $course->alter_name }} ({{ $course->name }})
                    </span>
                </div>
                
                
            </div>
            
        </div>
    </nav>
    <!--End Header-->
    
    
    <article class="hero-body exam-screen offwhite-bg padding-0 margin-top-30 margin-bottom-100">
        <div class="padding-5">
            
            <div class="exam-page padding-bottom-40">
                
                <section class="columns is-multiline margin-bottom-40 padding-bottom-40">
                
                    <div class="column is-12-desktop is-12-mobile font-size-16">
                        
                        <p class="font-size-20 font-weight-700 margin-bottom-10">Exam Summary</p>
                        
                        <p>
                            
                            <span class="font-size-18 font-weight-700 margin-top-10">Time allowed: no. of questions multiplied by 1.2 minutes</span>
                            <span class="font-size-18 margin-top-10">This exam is divided into three sections:</span>
                            <br>
                            
                            <ul class="padding-left-40" style="list-style: disc;">
                                <p class="font-weight-700">Section A</p>
                                <p class="margin-top-10">
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            15 objective test (OT) questions, each worth 2 marks.
                                        </li>
                                        <li class="margin-top-10">
                                            30 marks in total.
                                        </li>
                                    </ul>
                                </p>
                                <p class="font-weight-700">Section B</p>
                                <p class="margin-top-10">
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            Three OT cases, each containing a scenario which relates to five OT questions, each worth 2 marks.
                                        </li>
                                        <li class="margin-top-10">
                                            30 marks in total.
                                        </li>
                                    </ul>
                                </p>
                                <p class="font-weight-700">Section C</p>
                                <p class="margin-top-10">
                                    <ul class="padding-left-40" style="list-style: disc;">
                                        <li class="margin-top-10">
                                            Two constructed response questions, each containing a scenario which relates to one or more requirement(s).
                                        </li>
                                        <li class="margin-top-10">
                                            Each constructed response question is worth 20 marks in total.
                                        </li>
                                        <li class="margin-top-10">
                                            40 marks in total.
                                        </li>
                                    </ul>
                                </p>
                            </ul>
                            
                        </p>
                        
                        <p class="font-size-14 margin-bottom-10 margin-top-20">
                            Please note that the live exam is worth a total of 110 marks, 10 marks of which are for questions that do not count towards your final result and are included for quality assurance purposes. This specimen exam is worth a total of 100 marks, reflecting the element of the live exam on which your result will be based.
                        </p>
                        
                        <p class="font-size-14 margin-bottom-10 margin-top-20">
                            All questions are compulsory.
                        </p>
                        
                        <p class="font-size-14 margin-bottom-10 margin-top-20">
                            Click <span class="font-weight-700">Next</span> to start your exam.
                        </p>
                        
                    </div>
                    
                </section>
    
            </div>
            
        </div>
    </article>
    
    
    <!--Footer-->
    <footer class="hero-foot offwhite2-bg exam-foot">
        <nav class="tabs is-right">
            <div class="container">
                <ul>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-window_toggler="[5,6]">
                            <span class="prev-icon"></span>
                            Previous
                        </a>
                    </li>
                    <li>
                        <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-toggle="modal" data-target="#start-exam">
                            Next
                            <span class="next-icon"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </footer>
    <!--End Footer-->

</window>

