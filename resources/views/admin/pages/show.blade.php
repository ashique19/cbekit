@extends('admin.layout')

@section('main')

<section class="hero is-fullheight is-white is-bold">
    <div class="hero-body">
        <div class="container">
            
            <section class="columns is-multiline">
                
                <div class="column is-12">
                    <h1 class="title has-text-primary is-1">
                        PAGE @if($page) - {{ $page->id }} : {{$page->name}}@endif
                    </h1>
                </div>
                
                <div class="column is-12">
                    {!! errors($errors) !!}
                </div>
                
                <div class="column is-12">
                    <p>
                        Created At : {{$page->created_at}}
                        <br>
                        Last Updated At : {{$page->updated_at}}
                        <br>
                        <br />
                        Meta tag title : {{$page->meta_tag_title}}
                        <br />
                        Meta tag description : {{$page->meta_tag_description}}
                        <br />
                        Meta tag keywords : {{$page->meta_tag_keywords}}
                        <br>
                        <a href="{{action('Pages@edit', $page->id)}}" class="button is-small is-warning">edit</a>
                    </p>
                    <div class="is-pulled-right">
                        {!! Form::open(['url'=>action('Pages@destroy', $page->id), 'method'=>'DELETE']) !!}
                        {!! Form::hidden('id',$page->id) !!}
                        <button class="button is-danger is-small"> <i class="fa fa-trash-o"></i> </button>
                        {!! Form::close() !!}
                    </div>
                </div>
                
                <div class="column is-12">
                    <p>Details</p>
                    {!! $page->details !!}
                </div>
                
            </section>
            
        </div>
    </div>
</section>

@stop