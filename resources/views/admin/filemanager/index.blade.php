@extends('admin.layout')

@section('main')

<section class="hero is-fullheight is-primary is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title is-1">
                FIle manager
            </h1>
            
            <section class="columns is-multiline">
                <iframe src="{{ url('finder') }}" frameborder="0" class="is-12 column min-height-600" ></iframe>
            </section>
            
        </div>
        
    </div>
</section>

@stop