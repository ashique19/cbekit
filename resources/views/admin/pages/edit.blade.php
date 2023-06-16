@extends('admin.layout')

@section('css') <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" type="text/css" /> @stop

@section('js') <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js"></script> @stop

@section('main')

<section class="hero is-fullheight is-white is-bold">
    <div class="hero-body">
        <div class="container">
            
            <section class="columns is-multiline">
                
                <div class="column is-12">
                    <h1 class="title has-text-primary is-1">
                        EDIT PAGE @if($page) - {{ $page->id }} : {{$page->name}}@endif
                    </h1>
                </div>
                
                <div class="column is-12">
                    {!! errors($errors) !!}
                </div>
                
                <div class="column is-12">
                    {!! Form::open( ['method'=>'patch', 'class'=> 'columns is-multiline', 'url'=> action('Pages@update', $page->id), 'enctype'=>'multipart/form-data' ]) !!}
            
                
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('name', 'Name: ') !!}
                            {!! Form::text('name', $page->name , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('meta_tag_title', 'Meta tag title: ') !!}
                            {!! Form::text('meta_tag_title', $page->meta_tag_title , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('meta_tag_description', 'Meta tag description: ') !!}
                            {!! Form::text('meta_tag_description', $page->meta_tag_description , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('meta_tag_keywords', 'Meta tag keywords: ') !!}
                            {!! Form::text('meta_tag_keywords', $page->meta_tag_keywords , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-12">
                            {!! Form::label('details', 'Details: ') !!}
                            {!! Form::textarea('details', $page->details , ['class'=>'summernote textarea']) !!}
                        </div>
                            
                        <div class="column is-12 has-text-centered">
                            {!! Form::submit('Update Page', ['class'=>'button is-info is-large']) !!}
                        </div>
                    
                    {!! Form::close() !!}
                </div>
                
                
            </section>
            
        </div>
    </div>
</section>

<script>
    $('.summernote').summernote({
        height: 450
    });
</script>

@stop
