@extends('public.layouts.layout')
@section('title'){{ settings()->application_name }} | HOME - {{ settings()->application_slogan }}. @stop

@section('css') <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/> @stop

@section('js') <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> @stop


@section('bodyClass')homepage @stop

@section('main')


<article class="columns is-multiline margin-0 padding-0">
    
    <section class="column is-12-desktop is-12-mobile home-bg min-height-400 margin-0 padding-0">
        
        <h1 class="title">
        The Smartest Way to Handle
        <br>
        Computer Based Exams of ACCA
        </h1>

    </section>
    
    <section class="column is-10-desktop is-12-mobile min-height-200 margin-0 padding-0">
        
        <ul class="slick margin-top-20 margin-bottom-20">
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_1.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_2.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_3.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_4.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_5.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_6.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_7.png" alt="CBE KIT" class="image"></img>
            </li>
            <li class="padding-20">
                <img data-lazy="/public/img/backgrounds/_8.png" alt="CBE KIT" class="image"></img>
            </li>
        </ul>

    </section>
    
</article>

<span class="home-right-banner"></span>

@stop


@section('bodyScope')
<script type="text/javascript">
$(document).ready(function(){
    
    $('.slick').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        centerMode: true,
        adaptiveHeight: true,
        speed: 600,
        lazyLoad: 'ondemand',
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
            ]
        
    })
    
})
</script>
@stop