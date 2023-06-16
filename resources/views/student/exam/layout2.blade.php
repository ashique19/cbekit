<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="offwhite-bg nicescroll">
<!--<![endif]-->
<head>        
<!-- META SECTION -->
<title>@yield('title')</title>            
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="Md Ashiqul Islam; Email: ashique19@gmail.com; Phone: +880-178-563-6359">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/png" href="{{settings()->icon_photo}}"/>

<!-- CSS INCLUDE -->
<link rel="stylesheet" href="/public/css/spreadsheet.css" type="text/css" />
@foreach( front_css() as $css ) <link rel="stylesheet" type="text/css" href="{{ $css }}" media="all" /> @endforeach

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" type="text/css" />
@yield('css')

<!-- END CSS INCLUDE -->                               


<!-- START SCRIPTS -->

    <script type="text/javascript" src="/public/js/spreadsheet.js"></script>
    <script type="text/javascript" src="/public/js/excel.js"></script>
@foreach( front_js() as $js) <script type="text/javascript" src="{{ $js }}"></script> @endforeach


<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js"></script>
@yield('js')
<!-- END SCRIPTS --> 

</head>
<body>
    
<main class="hero offwhite2-bg main-bg exam-layout2">

@yield('main')
  


@include('student.exam.partials.start-exam-modal')

@include('student.exam.partials.question-navigator-modal')

@include('student.exam.partials.partially-attempted')

@include('student.exam.partials.exam-progress')

@include('student.exam.partials.f5-f9-help-and-formulae')

@include('student.exam.partials.read-fullpage')

@include('student.exam.partials.exit')

@include('student.exam.partials.scratch-pad-modal')

@include('student.exam.partials.calculator-modal')



</main>

@yield('bodyScope')
<script type="text/javascript" src="/public/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>
<script type="text/javascript" src="/public/js/exam-screen.js"></script>
<script type="text/javascript">
    
$(document).ready(function(){
    
    $('.show-instruction').click(function(){
        $('#formulae').addClass('is-hidden');
        $('#instruction').removeClass('is-hidden');
    })
    
    $('.show-formulae').click(function(){
        $('#formulae').removeClass('is-hidden');
        $('#instruction').addClass('is-hidden');
    })
    
})


window.onload = function(){
    
    $('[data-lazy]').each(function(i,v){
        $(v).attr('src', $(v).data('lazy') ).removeAttr('data-lazy');
    })
    
}
    
</script>
</body>

</html>

        