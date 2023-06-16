@extends('public.layouts.layout')
@section('title'){{settings()->application_name}}- Contact us. @stop
@section('main')

<section class="box margin-top-30 transparent-bg is-shadowless">

<section class="columns is-multiline">

    <div class="column is-12-desktop is-12-mobile">
        <h1 class="title is-2 white-text font-weight-100 has-text-uppercase">Contact Us in 4 ways</h1>
    </div>
    
    <div class="column is-12-desktop is-12-mobile">
        
        <p class="margin-bottom-30">
            <a href="mailto:{{ settings()->helpmail }}">
                <span class="height-40 width-40 is-rounded blue-bg block white-text padding-left-15 padding-top-10 pull-left">1</span> 
                <span class="margin-left-50 block padding-top-10">Email us as {{ settings()->helpmail }} .</span>
            </a>
        </p>
        <p class="margin-bottom-30">
            <a href="#" class="load-live-chat">
                <span class="height-40 width-40 is-rounded blue-bg block white-text padding-left-15 padding-top-10 pull-left">2</span> 
                <span class="margin-left-50 block padding-top-10">Live chat with our technical team (click on chat icon on bottom right corner of this page).</span>
            </a>
        </p>
        <p class="margin-bottom-30">
            <a href="https://m.me/cbekit" target="_blank" nofollow>
                <span class="height-40 width-40 is-rounded blue-bg block white-text padding-left-15 padding-top-10 pull-left">3</span> 
                <span class="margin-left-50 block padding-top-10"> Message us at our Fb page.</span>
            </a>
        </p>
        {{--
        <p class="margin-bottom-30">
            <a href="tel:+8801785636359">
                <span class="height-40 width-40 is-rounded blue-bg block white-text padding-left-15 padding-top-10 pull-left">4</span> 
                <span class="margin-left-50 block padding-top-10"> Call me (Ashiqul, CBE KIT)</span>
            </a>
        </p>
        --}}
        
    </div>
    
</section>

</section>

@stop

@section('js')
<script>
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5d27d9fd9b94cd38bbe6ea97/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);

</script>
@stop