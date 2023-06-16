@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        @if( $course )
        
        <h1 class="title is-1">
            <span class="has-text-info">{{ $course->name }}</span>
        </h1>
        <h2 class="subtitle is-2 white-text slim-gray-bottom-border">{{ $course->alter_name }}</h2>
        
        
        <h3 class="subtitle font-size-28 has-text-info has-text-uppercase">
            Students
            
            <a href="{{ action('TeacherCourses@index', $course->id) }}" class="button is-info is-pulled-right">
                Exams
            </a>
            
        </h3>
        
        
        
        <table class="table is-bordered is-striped is-hoverable">
            <thead>
                <tr>
                    <th>Students</th>
                    <th>Free/Premium</th>
                    <th>Active</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Exam Attempts</th>
                </tr>
            </thead>
            <tbody>
                @if( count( $students ) > 0 )
                @foreach( $students as $student )
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->pivot->is_premium == 1 ? 'Premium' : $student->pivot->is_free == 1 ? 'Free' : '' }}</td>
                    <td>{{ $student->pivot->is_active == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $student->pivot->start_date }}</td>
                    <td>{{ $student->pivot->end_date }}</td>
                    <td>
                        <a href="{{ action('TeacherExams@studentAttempts', [$course->id, $student->id]) }}" class="button is-small is-primary font-weight-700">({{ $student->attempts()->count() }}) Attempts</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        
        @else
        
        <h2 class="subtitle is-2">Sorry, we could not find your requested course.</h2>
        
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
        