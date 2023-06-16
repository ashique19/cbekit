@extends('public.layouts.layout')
@section('title')Dashboard - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">
        <article class="column is-12-desktop is-12-mobile">
            <h1 class="title is-1 white-text">
                <span class="has-text-info">C</span>omputer
                <span class="has-text-info">B</span>ased
                <span class="has-text-info">E</span>xam
            </h1>
            <h2 class="subtitle is-4 has-text-uppercase">
                <span class="black-text">on ACCA syllabus</span>
            </h2>
            <h2 class="subtitle is-4">Practice like exam environment, with exam like questions.</h2>
            
            <span class="button is-info white-text is-size-3 padding-10">
                <i class="fa fa-angle-left margin-15"></i> 
                Select a course from list
            </span>
        </article>

    
    
        <div class="column is-6-desktop is-12-mobile">
            <canvas 
                id="pie-chart" 
                width="400" 
                height="400" 
                data-names="{{ json_encode( $graph['name'] ) }}" 
                data-datas="{{ json_encode( $graph['data'] ) }}"
                data-backgroundColor='{{ json_encode( $graph["backgroundColor"] ) }}'
                data-borderColor= '{{ json_encode( $graph["borderColor"] ) }}'
            ></canvas>
        </div>

        
        
        
    </main>

</article>


@stop

@section('bodyScope')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>

$(document).ready(function(){

    let pieChartCtx = $('#pie-chart');
    let lineChartCtx = $('#line-chart');
    let radarChartCtx = $('#radar-chart');

    let names_json = JSON.parse( pieChartCtx.attr('data-names') );
    let data_json = JSON.parse( pieChartCtx.attr('data-datas') );
    let data_backgroundColor = JSON.parse( pieChartCtx.attr('data-backgroundColor') );
    let data_borderColor = JSON.parse( pieChartCtx.attr('data-borderColor') );

    console.log({ names_json, data_json, data_backgroundColor, data_borderColor });

    // Exam attempts on each enrolled courses
    let pieChart = new Chart(pieChartCtx, {
        type: 'pie',
        data: {
            labels: names_json,
            datasets: [{
                label: '# of attempts',
                data: data_json,
                backgroundColor: data_backgroundColor ,
                borderColor: data_borderColor ,
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

    /**
    let lineChart = new Chart(lineChartCtx, {
        type: 'line',
        data: {
            labels: ['FA1', 'AB', 'MA'],
            datasets: [{
                label: '# of successful attempts',
                data: [12, 19, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
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


    let radarChart = new Chart(radarChartCtx, {
        type: 'radar',
        data: {
            labels: ['FA1', 'AB', 'MA', 'MA2', 'PM'],
            datasets: [{
                label: 'Attempt % in past 30 days',
                data: [70, 10, 43, 0, 22],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scale: {
                angleLines: {
                    display: false
                },
                ticks: {
                    suggestedMin: 50,
                    suggestedMax: 100
                }
            }
        }
    });

    */

})

</script>
@stop
        