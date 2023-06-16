@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css">
@stop



@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">
        
        @if( $course )

        <article class="column is-12-desktop is-12-mobile">
            
            <h1 class="title is-1">
                <span class="has-text-info">{{ $course->name }}</span>
                @if( $enrolled_course )
                @if( $enrolled_course->teacher )
                <span class="font-size-18">Teacher: {{ $enrolled_course->teacher->name }}</span>
                @endif
                @endif
            </h1>
            <h2 class="subtitle is-2 white-text">{{ $course->alter_name }}</h2>
            
            <table class="table is-bordered is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Features</th>
                        <th>
                            Free
                            @if( free_enroled($course->id) )
                            <span class="icon has-text-success">
                                <i class="fa fa-check-circle"></i>
                            </span>
                            @endif
                        </th>
                        <th>
                            Premium
                            @if( premium_enroled($course->id) )
                            <span class="icon has-text-success">
                                <i class="fa fa-check-circle"></i>
                            </span>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>MCQ</td>
                        <td>10 Questions</td>
                        <td>Unlimited Questions</td>
                    </tr>
                    <tr>
                        <td>Detailed Questions</td>
                        <td>View only (Cannot answer)</td>
                        <td>Full access</td>
                    </tr>
                    <tr>
                        <td>Answer review by Tutor</td>
                        <td>No</td>
                        <td>Yes</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="buttons">
                
                @if( free_enroled($course->id) )
                <a class="button is-large is-info" disabled>Enroled (Free)</a>
                @elseif( ! free_enroled($course->id) && ! premium_enroled($course->id) )
                <a href="{{ action('StudentCourses@enroleFree', $course->id) }}" class="button is-info" >Enrole (Free)</a>
                @endif

                {{--
                @if( premium_enroled($course->id) )
                <a class="button is-large is-success" disabled >Enroled (Premium)</a>
                @else
                <a href="{{ action('StudentCourses@enrolePremium', $course->id) }}" class="button is-large is-success">Enrole (Premium)</a>
                @endif
                --}}
                
                @if( free_enroled($course->id) || premium_enroled($course->id) )
                <a href="{{ action('StudentCourses@selectExam', $course->id) }}" class="button is-large is-info">Go to Exams</a>
                <!--<a href="{{ action('Exams@start', $course->id) }}" class="button is-large white-bg red-text">Start Exam</a>-->
                @endif

                
                
            </div>

        </article>

        <article class="column is-12-desktop is-12-mobile columns is-multiline">

            <div class="column is-4-desktop is-12-mobile box">
                <h4 class="subtitle is-4">Your orverall status</h4>
                <table class="table is-triped is-bordered is-fullwidth is-narrow">
                    <tbody>
                        <tr>
                            <td></td>
                            <td>Sessions</td>
                        </tr>
                        <tr>
                            <td>Total Exams</td>
                            <td>{{ $graph_1['data'][0] + $graph_1['data'][1] }}</td>
                        </tr>
                        <tr>
                            <td>Successful</td>
                            <td>{{ $graph_1['data'][0] }}</td>
                        </tr>
                        <tr>
                            <td>Unsuccessful</td>
                            <td>{{ $graph_1['data'][1] }}</td>
                        </tr>
                    </tbody>
                </table>
                <canvas 
                    id="pie-chart" 
                    width="400" 
                    height="400" 
                    data-names="{{ json_encode( $graph_1['name'] ) }}" 
                    data-datas="{{ json_encode( $graph_1['data'] ) }}"
                ></canvas>
            </div>

            <div class="column is-8-desktop is-12-mobile box">
                <h4 class="subtitle is-4">Your Last 10 Attempts</h4>
                <table class="table is-triped is-bordered is-fullwidth is-narrow">
                    <tbody>
                        <tr>
                            <td></td>
                            @if( count( $graph_2['labels']) > 0 )
                            @foreach( $graph_2['labels'] as $label )
                            <td>{{ $label }}</td>
                            @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>Correct</td>
                            @if( count( $graph_2['datasets']['right']) > 0 )
                            @foreach( $graph_2['datasets']['right'] as $right )
                            <td>{{ $right }}</td>
                            @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>Wrong</td>
                            @if( count( $graph_2['datasets']['wrong']) > 0 )
                            @foreach( $graph_2['datasets']['wrong'] as $wrong )
                            <td>{{ $wrong }}</td>
                            @endforeach
                            @endif
                        </tr>
                        <tr>
                            <td>Un-attempted</td>
                            @if( count( $graph_2['datasets']['unattempted']) > 0 )
                            @foreach( $graph_2['datasets']['unattempted'] as $unattempted )
                            <td>{{ $unattempted }}</td>
                            @endforeach
                            @endif
                        </tr>
                    </tbody>
                </table>
                <canvas 
                    id="bar-chart" 
                    width="400" 
                    height="400" 
                    data-bar={{ json_encode( $graph_2 ) }}
                ></canvas>
            </div>

        </article>
        
        @endif
        
    </main>

</article>


@stop
        


@section('bodyScope')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>

$(document).ready(function(){

    let pieChartCtx = $('#pie-chart');
    let barChartCtx = $('#bar-chart');
    let bar_data = JSON.parse( barChartCtx.attr('data-bar') );

    let names_json = JSON.parse( pieChartCtx.attr('data-names') );
    let data_json = JSON.parse( pieChartCtx.attr('data-datas') );

    console.log(bar_data);

    // Exam attempts on each enrolled courses
    let pieChart = new Chart(pieChartCtx, {
        type: 'pie',
        data: {
            labels: names_json,
            datasets: [{
                label: '# of attempts',
                data: data_json,
                backgroundColor: ['rgba(10,255,100, 0.21)', 'rgba(100,25,100, 0.21)'] ,
                borderColor: ['rgba(10,255,100, 0.21)', 'rgba(100,25,100, 0.21)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    
    let barChart = new Chart(barChartCtx, {
        type: 'bar',
        data: {
			labels: bar_data.labels,
			datasets: [{
				label: 'Correct',
				backgroundColor: 'rgba(10,255,100, 0.2)',
				data: bar_data.datasets.right
			}, {
				label: 'Wrong',
				backgroundColor: 'rgba(100,25,10, 0.2)',
				data: bar_data.datasets.wrong
			}, {
				label: 'Unattempted',
				backgroundColor: 'rgba(255,0,100, 0.2)',
				data: bar_data.datasets.unattempted
			}]

		},
        options: {
            title: {
                display: true,
                text: 'Chart.js Bar Chart - Stacked'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });

})

</script>
@stop
        