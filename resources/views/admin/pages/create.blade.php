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
                        CREATE PAGE
                    </h1>
                </div>
                
                <div class="column is-12">
                    {!! errors($errors) !!}
                </div>
                
                <div class="column is-12">
                    {!! Form::open( ['url'=> action('Pages@store'), 'class'=>'columns is-multiline', 'enctype'=>'multipart/form-data' ]) !!}


                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('name', 'Name: ') !!}
                            {!! Form::text('name', old('name') , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('meta_tag_title', 'Meta tag title: ') !!}
                            {!! Form::text('meta_tag_title', old('meta_tag_title') , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('meta_tag_description', 'Meta tag description: ') !!}
                            {!! Form::text('meta_tag_description', old('meta_tag_description') , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-6-desktop is-12-mobile">
                            {!! Form::label('meta_tag_keywords', 'Meta tag keywords: ') !!}
                            {!! Form::text('meta_tag_keywords', old('meta_tag_keywords') , ['class'=>'input']) !!}
                        </div>
                            
                        <div class="column is-12">
                            {!! Form::label('details', 'Details: ') !!}
                            {!! Form::textarea('details', old('details') , ['class'=>'summernote textarea']) !!}
                        </div>
                            
                        <div class="column is-12 text-center">
                            {!! Form::submit('Save Page', ['class'=>'button is-info is-large']) !!}
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
