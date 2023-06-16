
@extends('admin.layout')

@section('title') Create new Blogslide @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>Blogslides</center></h1>


@if($errors->any())
<section class="row panel-body">
    <h4>Please check:</h4>
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>
    <hr>
</section>    
@endif


<section class="col-sm-6 col-sm-offset-3">

<h3>Create Blogslide</h3>


{!! Form::open( ['url'=> action('Blogslides@store'), 'enctype'=>'multipart/form-data' ]) !!}

    
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('subtitle', 'Subtitle: ') !!}
            {!! Form::text('subtitle', old('subtitle') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('slide_photos', 'Slide photo: ') !!}
            {!! Form::file('slide_photos', ['class'=>'form-control file']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('blog_id', 'Blog: ') !!}
            {!! Form::select('blog_id', \App\Blog::lists('name', 'id'), old('blog_id') , ['class'=>'form-control select2']) !!}
        </div>
            
    <div class="form-group">
        {!! Form::submit('Save Blogslide', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        