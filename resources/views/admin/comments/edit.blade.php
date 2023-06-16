
@extends('admin.layout')

@section('title') Edit Comments @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>Modify Comment</center></h1>


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

{!! Form::open( ['method'=>'patch', 'url'=> action('Comments@update', $comment->id), 'enctype'=>'multipart/form-data' ]) !!}

    
            <div class="form-group">
                {!! Form::label('name', 'Name: ') !!}
                {!! Form::text('name', $comment->name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('user_id', 'User: ') !!}
                {!! Form::select('user_id', \App\User::lists('name', 'id'), $comment->user_id , ['class'=>'form-control select2']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('blog_id', 'Blog: ') !!}
                {!! Form::select('blog_id', \App\Blog::lists('name', 'id'), $comment->blog_id , ['class'=>'form-control select2']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('status', 'Status: ') !!}
                {!! Form::text('status', $comment->status , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('is_reply', 'Is reply: ') !!}
                {!! Form::select('is_reply', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], $comment->is_reply , ['class'=>'form-control']) !!}
            </div>
            
            <div class="form-group">
                {!! Form::label('comment_id', 'Comment: ') !!}
                {!! Form::select('comment_id', \App\Comment::lists('name', 'id'), $comment->comment_id , ['class'=>'form-control select2']) !!}
            </div>
                
    <div class="form-group">
        {!! Form::submit('Update Comment', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        