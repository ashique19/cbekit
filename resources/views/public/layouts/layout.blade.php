<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
@include('public.partials.head')
<body>
<span id="page-loader-placeholder"><div id="placeholder"><div class="lds-ripple"><div></div><div></div></div><div id="project-name">{{ settings()->application_name }}</div></div></span>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109438059-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    
    gtag('config', 'UA-109438059-2');
</script>

    
<main class="hero is-fullheight is-bold is-white main-bg">
  
@include('public.navs.topbar')

<!-- Hero content: will be in the middle -->
<div class="hero-body @yield('bodyClass')">

    <div class="container">
        
        @yield('main')
        
    </div>
</div>

</main>

@include('public.footers.footer')

@yield('bodyScope')


@yield('js')
</body>

</html>

        