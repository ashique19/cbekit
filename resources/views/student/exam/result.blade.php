@extends('public.layouts.layout')
@section('title')Exam Result - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        <h1 class="title is-3 has-text-info">Exam Result</h1>
        
        <div class="box">
            <h2 class="subtitle is-2">Summary</h2>
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
            @foreach( $sections as $section )
            @if( $questions->where('section', $section)->count() > 0 )

            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                    Section {{ strtoupper($section) }}
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
                                    <th>Marking Type</th>
                                    <th>See Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $questions->where('section', $section) as $i => $q )
                            <tr>
                                <td>{{ $i +1 }}</td>
                                <td>{{ $q->name }}</td>
                                <td>{{ $q->options()->correct()->sum('marks') }}</td>
                                <td>{{ $attempt->answers()->where('question_id', $q->id)->sum('achieved_mark') }}</td>
                                <td>
                                    @if( $q->options()->correct()->count() > 0 )
                                    @foreach( $q->options()->correct()->orderBy('qref')->select('name', 'qref')->get() as $correct_q )
                                    <p class="font-size-12" correct-ans-qref="{{ $correct_q->qref }}">{{ $correct_q->name }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if( $attempt->answers()->where('question_id', $q->id)->count() > 0 )
                                    @foreach( $attempt->answers()->where('question_id', $q->id)->orderBy('qref')->get() as $ans )
                                    <p class="font-size-12" given-ans-qref="{{ $ans->qref }}" >{{ $ans->qtype != 'word' && $ans->qtype != 'excel' ? $ans->given_answer : '' }}</p>
                                    @endforeach
                                    @endif
                                </td>
                                <td>{{ $q->marking_type }}</td>
                                <td>
                                    <a href="{{ action('Questions@explanation', [$attempt->id, $q->id]) }}" target="_blank" class="tag">Explanation & Comment</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @endif
            @endforEach

        </div>
        
    </main>

</article>


@stop
        