@extends('admin.layout')

@section('main')

<section class="hero is-fullheight is-primary is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title is-1">
                {{ settings()->application_name }}
            </h1>
            <h2 class="subtitle">
                {{ settings()->application_slogan }}
            </h2>
        </div>
    </div>
</section>

@stop