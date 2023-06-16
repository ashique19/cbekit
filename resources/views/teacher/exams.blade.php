@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">

        <div class="column is-12-desktop is-12-mobile">
            
            <h1 class="title is-1">
                <span class="has-text-info">{{ $course->name }}</span>
            </h1>
            <h2 class="subtitle is-2 white-text slim-gray-bottom-border">{{ $course->alter_name }}</h2>
            
            <a href="{{ action('TeacherCourses@students', $course->id) }}" class="is-pulled-right">
                <i class="fa fa-angle-right margin-right-5 font-size-18"></i>
                Students who attempted exam
            </a>

        </div>

        <div class="column is-12-desktop is-12-mobile">

            <h3 class="subtitle font-size-28 has-text-info has-text-uppercase">
                Create Exam Session
            </h3>

            {!! Form::open([ "url"=> action("Exams@store"), "class"=> "save-exam" ]) !!}
            {!! Form::hidden("course_id", $course->id) !!}
            <div class="control margin-bottom-10 black-text">
                <input class="input" type="text" placeholder="Name the exam" name="name" required autofocus />
            </div>
            <div class="control margin-bottom-10 black-text">
                <input type="checkbox" value="1" name="is_free" /> Free
                <input type="checkbox" value="1" name="is_premium" /> Premium
            </div>
            <div class="control margin-bottom-10 black-text">
                <input class="input" type="text" placeholder="Duration (Minutes)" name="exam_duration_minutes" required />
            </div>
            <div class="control margin-bottom-20">
                <button class="button is-info is-outlined is-fullwidth" type="submit">Save</button>
            </div>
            {!! Form::close() !!}


        </div>
        
        
        @if( count($exams) > 0 )

        <div class="column is-12-desktop is-12-mobile">

            <hr>

            <h3 class="subtitle font-size-28 has-text-info has-text-uppercase">
                Existing Exam Sessions
            </h3>
            
            <table class="table is-bordered is-striped is-hoverable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Questions</th>
                        <th>Free/Premium</th>
                        <th>Last Updated</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $exams as $exam )
                    <tr>
                        <td>{{ $exam->name }}</td>
                        <td>{{ $exam->questions()->count() }}</td>
                        <td>{{ $exam->is_free ? 'Free' : ( $exam->is_premium ? 'Premium' : '' ) }}</td>
                        <td>{{ $exam->updated_at->format('Y-M-d') }}</td>
                        <td>
                            <a href="{{ action('Exams@edit', $exam->id) }}" class="button is-small is-primary">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

        @else
        
        <h4 class="subtitle is-4">There is no exam prepared for this course yet.</h4>
        
        @endif
        
        
    </main>

</article>

<script>
    
    $(document).on({
        
        submit: function(e){
            
            e.preventDefault();
            
            var form = $(this),
                button = form.find('button[type="submit"]'),
                url = form.attr('action'),
                data = form.serializeArray();
                
            button.addClass('is-loading');
            
            $.post(url, data, function(result){
                
                button.removeClass('is-loading');
                
                if( result.stat == 'success' ){
                
                    button.text('Success');
                    
                    window.location.href = result.output;
                
                }else{
                    
                    button.text( result.output );
                    
                }
                
            });
            
        }
        
    }, '.save-exam');
    
</script>


@stop
        