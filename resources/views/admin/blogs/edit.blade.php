
@extends('admin.layout')

@section('title') Edit Blogs @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>Modify Blog</center></h1>


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


<section class="col-sm-10 col-sm-offset-1">

{!! Form::open( ['method'=>'patch', 'url'=> action('Blogs@update', $blog->id), 'enctype'=>'multipart/form-data' ]) !!}

    
            <div class="form-group col-sm-6">
                {!! Form::label('name', 'Name: ') !!}
                {!! Form::text('name', $blog->name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group col-sm-6">
                <label for="banner_photos">Banner photo: <span class="badge badge-primary"><input type="checkbox" value="1" name="banner_photo_delete" /> remove</span></label>
                {!! Form::file('banner_photos' , ['class'=>'form-control file']) !!}
            </div>
                
            <div class="form-group col-sm-6">
                {!! Form::label('public-link', 'Public Link: ') !!}
                {!! Form::text('public-link', $blog->link , ['class'=>'form-control', 'disabled'=>'disabled']) !!}
            </div>
                
            <div class="form-group col-sm-6">
                {!! Form::label('status', 'Status: ') !!}
                {!! Form::select('status', ['0'=>'Draft', '1'=>'Waiting for approval', '2'=>'Published', '3'=>'Trashed'], $blog->status , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group col-xs-12">
                {!! Form::label('details', 'Details: ') !!}
                {!! Form::textarea('details', $blog->details , ['class'=>'form-control summernote']) !!}
            </div>
                
    <div class="form-group">
        {!! Form::submit('Update Blog', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        