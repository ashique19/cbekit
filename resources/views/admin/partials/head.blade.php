<head>        
<!-- META SECTION -->
<title>@yield('title')</title>            
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="Md Ashiqul Islam; Email: ashique19@gmail.com; Phone: +880-178-563-6359">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/png" href="{{settings()->icon_photo}}"/>

<link rel="dns-prefetch" href="//code.jquery.com" />
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
<link rel="dns-prefetch" href="//www.google.com">
<link rel="dns-prefetch" href="//www.google-analytics.com">

@yield('meta')
<!-- END META SECTION -->

<!-- CSS INCLUDE -->
@foreach( back_css() as $css ) <link rel="stylesheet" type="text/css" href="{{ $css }}" media="all" /> @endforeach

@yield('css')

<!-- END CSS INCLUDE -->                               


<!-- START SCRIPTS -->
@foreach( back_js() as $js) <script type="text/javascript" src="{{ $js }}"></script> @endforeach

@yield('js')
<!-- END SCRIPTS --> 


<!--Start Pre-loading-->

<!--
-- rel="prefetch" enables preloading and caching assets (e.g. css, js, img etc.)
-->
<!--<link rel="prefetch" href="image.png">-->
@yield('prefetch')


<!--
-- rel="prerender" loads and caches entire page so that it can display the page instantly on request.
-->
<!--<link rel="prerender" href="http://css-tricks.com">-->
@yield('prerender')

<!--END Pre-loading-->

</head>