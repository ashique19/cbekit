@extends('public.layouts.layout')
@section('title')Exam Result - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        <h1 class="title is-3 has-text-info">Exam Result</h1>
        
        <div class="box">
            @if( $student )
            <h2 class="subtitle is-4">
            @if( strlen( $student->user_photo ) > 10 )
            <img src="{{ $student->user_photo }}" alt="profile photo" class="image pull-left margin-right-10" width="50"> 
            @endif
            <span class="pull-left padding-top-10">{{ $student->name }}</span>
            </h2>
            @endif
            <h3 class="subtitle is-3 margin-top-70">Summary</h3>
            <p>Exam Name: {{ $exam->name }}</p>
            <table class="table is-bordered">
                <tbody>
                    <tr>
                        <td width="250">Time Allowed: {{ $exam->exam_duration_minutes }} Minutes</td>
                        <td width="250">Time Taken: {{ round( $attempt->elapsed_second / 60 ) }} Minutes</td>
                        <td width="150">Mark: {{ $attempt->achieved_mark }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        
        <div class="box">
            <h2 class="subtitle is-3">Detailed Report</h2>
            @if( $questions->where('section', 'a')->count() > 0 )

            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                    Section A
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Allocated Mark</th>
                                    <th>Achieved Mark</th>
                                    <th>Correct Ans</th>
                                    <th>Given Ans</th>
                                    <th>See Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $questions->where('section', 'a') as $i => $q )
                            <tr>
                                <td>{{ $i +1 }}</td>
                                <td>{{ $q->name }}</td>
                                <td>{{ $q->options()->sum('marks') }}</td>
                                <td>{{ $attempt->answers()->where('question_id', $q->id)->sum('achieved_mark') }}</td>
                                <td>
                                    @if( $q->options()->correct()->count() > 0 )
                                    @foreach( $q->options()->correct()->pluck('name') as $name )
                                    <p class="font-size-12">{{ $name }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if( $attempt->answers()->where('question_id', $q->id)->count() > 0 )
                                    @foreach( $attempt->answers()->where('question_id', $q->id)->pluck('given_answer','qtype') as $qtype => $ans )
                                    <p class="font-size-12">{{ $qtype != 'word' && $qtype != 'excel' ? $ans : '' }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ action('TeacherExams@explanation', [$attempt->id, $q->id]) }}" target="_blank" class="tag">Explanation</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @endif
            @if( $questions->where('section', 'b')->count() > 0 )

             <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                    Section B
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Allocated Mark</th>
                                    <th>Achieved Mark</th>
                                    <th>Correct Ans</th>
                                    <th>Given Ans</th>
                                    <th>See Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $questions->where('section', 'b') as $i => $q )
                            <tr>
                                <td>{{ $i +1 }}</td>
                                <td>{{ $q->name }}</td>
                                <td>{{ $q->options()->sum('marks') }}</td>
                                <td>{{ $attempt->answers()->where('question_id', $q->id)->sum('achieved_mark') }}</td>
                                <td>
                                    @if( $q->options()->correct()->count() > 0 )
                                    @foreach( $q->options()->correct()->pluck('name') as $name )
                                    <p class="font-size-12">{{ $name }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if( $attempt->answers()->where('question_id', $q->id)->count() > 0 )
                                    @foreach( $attempt->answers()->where('question_id', $q->id)->pluck('given_answer','qtype') as $qtype => $ans )
                                    <p class="font-size-12">{{ $qtype != 'word' && $qtype != 'excel' ? $ans : '' }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ action('TeacherExams@explanation', [$attempt->id, $q->id]) }}" target="_blank" class="tag">Explanation</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @endif
            @if( $questions->where('section', 'c')->count() > 0 )

             <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                    Section C
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Name</th>
                                    <th>Allocated Mark</th>
                                    <th>Achieved Mark</th>
                                    <th>Correct Ans</th>
                                    <th>Given Ans</th>
                                    <th>See Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $questions->where('section', 'c') as $i => $q )
                            <tr>
                                <td>{{ $i +1 }}</td>
                                <td>{{ $q->name }}</td>
                                <td>{{ $q->options()->sum('marks') }}</td>
                                <td>{{ $attempt->answers()->where('question_id', $q->id)->sum('achieved_mark') }}</td>
                                <td>
                                    @if( $q->options()->correct()->count() > 0 )
                                    @foreach( $q->options()->correct()->pluck('name') as $name )
                                    <p class="font-size-12">{{ $name }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if( $attempt->answers()->where('question_id', $q->id)->count() > 0 )
                                    @foreach( $attempt->answers()->where('question_id', $q->id)->pluck('given_answer','qtype') as $qtype => $ans )
                                    <p class="font-size-12">{{ $qtype != 'word' && $qtype != 'excel' ? $ans : '' }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ action('TeacherExams@explanation', [$attempt->id, $q->id]) }}" target="_blank" class="tag">Explanation</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @endif
        </div>
        
    </main>

</article>


@stop
        