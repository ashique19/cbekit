@extends('public.layouts.layout')
@section('title')
{{settings()->application_name}}-@if($page){{$page->name}} @endif 
@stop

@section('meta')
    @if($page)
        <meta name="title" content="{{$page->meta_tag_title}}">
        <meta name="description" content="{{$page->meta_tag_description}}">
        <meta name="keywords" content="{{$page->meta_tag_keywords}}">
    @endif
@stop

@section('main')

@if($page)

<nav class="level">
    <div class="level-item level-left">
        <div>
            <h1 class="title is-1 white-text">{{ ucfirst( str_replace('-', ' ', $page->name) )}}</h1>
        </div>
    </div>
</nav>

<section class="columns">
    <div class="column is-12">
        
        <div class="content">{!! $page->details !!}</div>
        
    </div>
</section>

@else
    
    <!--If the Page does not exist, we say sorry! -->
    
    <div class="panel panel-default">
        <h2 class="page-title"><center>Sorry! The page you are looking for, does not exist..</center></h2>
        <strong><center>Come again later to see if it exists or <a href="{{route('home')}}">checkout our collection</a>.</center></strong>
    </div>

@endif


@stop
        