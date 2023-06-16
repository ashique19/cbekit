
@extends('admin.layout')

@section('title') Create new Blogslide @stop

@section('main')

<h1><center>Blogslides</center></h1>


@if($errors->any())
<section class="col-sm-11">
    <h4>Please check:</h4>
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>
    <hr>
</section>    
@endif


<section class="col-sm-11">

<h3>Create Blogslide</h3>


{!! Form::open( ['url'=> action('Blogs@blogslidesStore', $blog->id), 'class'=>'form form-horizontal', 'enctype'=>'multipart/form-data' ]) !!}

    
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
        {!! Form::submit('Save Blogslide', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        