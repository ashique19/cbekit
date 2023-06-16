
@extends('admin.layout')

@section('title') Create new Blog @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>New Blog</center></h1>


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


<section class="col-sm-10 col-sm-offset-1">


{!! Form::open( ['url'=> action('Blogs@store'), 'enctype'=>'multipart/form-data' ]) !!}

    
        <div class="form-group col-sm-6">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control', 'required'=>'required', 'min'=>5, 'placeholder'=>'give the blog a name', 'autofocus'=>'autofocus']) !!}
        </div>
            
        <div class="form-group col-sm-6">
            {!! Form::label('banner_photos', 'Banner: ') !!}
            {!! Form::file('banner_photos', ['class'=>'form-control file']) !!}
        </div>
            
        <div class="form-group col-sm-6">
            {!! Form::label('status', 'Status: ') !!}
            {!! Form::select('status', ['0'=>'Draft', '1'=>'Waiting for approval', '2'=>'Published', '3'=>'Trashed'], old('status') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group col-sm-6">
            {!! Form::label('public-link', 'Public Link: ') !!}
            {!! Form::text('public-link', null , ['class'=>'form-control', 'disabled'=>'disabled', 'placeholder'=>'Link will be generated automatically']) !!}
        </div>
            
        <div class="form-group col-xs-12">
            {!! Form::label('details', 'Details: ') !!}
            {!! Form::textarea('details', old('details') , ['class'=>'form-control summernote', 'required'=>'required', 'placeholder'=>'Details of the blog. Recommended more than 20 charecters.']) !!}
        </div>
            
    <div class="form-group">
        {!! Form::submit('Save Blog', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        