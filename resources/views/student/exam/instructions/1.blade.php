<article class="hero-body exam-screen">
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