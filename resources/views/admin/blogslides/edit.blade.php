
@extends('admin.layout')

@section('title') Edit Blogslides @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>Modify Blogslide</center></h1>


@if($errors->any())
<section class="col-sm-6 col-sm-offset-3">
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

{!! Form::open( ['method'=>'patch', 'url'=> action('Blogslides@update', $blogslide->id), 'enctype'=>'multipart/form-data' ]) !!}

    
            <div class="form-group">
                {!! Form::label('name', 'Name: ') !!}
                {!! Form::text('name', $blogslide->name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('subtitle', 'Subtitle: ') !!}
                {!! Form::text('subtitle', $blogslide->subtitle , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                <label for="slide_photos">Slide photo: <span class="badge badge-primary"><input type="checkbox" value="1" name="slide_photo_delete" /> remove</span></label>
                {!! Form::file('slide_photos' , ['class'=>'form-control file']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('blog_id', 'Blog: ') !!}
                {!! Form::select('blog_id', \App\Blog::lists('name', 'id'), $blogslide->blog_id , ['class'=>'form-control select2']) !!}
            </div>
                
    <div class="form-group">
        {!! Form::submit('Update Blogslide', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        