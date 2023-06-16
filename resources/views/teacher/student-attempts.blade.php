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
            {{ $student->name }}
        </h3>
        
        
        <table class="table is-bordered is-striped is-hoverable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Marks</th>
                    <th>Achieved</th>
                    <th>Time Taken</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @if( count( $attempts ) )
                @foreach( $attempts as $attempt )
                <tr>
                    <td>{{ $attempt->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $attempt->name }}</td>
                    <td>{{ $attempt->exam_mark }}</td>
                    <td>{{ $attempt->achieved_mark }}</td>
                    <td>{{ $attempt->elapsed_second }}</td>
                    <td><a href="{{ action('TeacherExams@studentAttemptDetail', $attempt->id) }}" class="button is-small is-primary">Detail</a></td>
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
        