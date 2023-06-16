
@extends('admin.layout')

@section('title') Comment @stop

@section('main')

<h1><center>Comments @if($comments) : {{$comments->total()}} @endif</center></h1>

<section class="col-sm-10 col-sm-offset-1">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Comments@searchIndex')]) !!} 
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('blog_id', 'Blog: ') !!}
            {!! Form::select('blog_id', \App\Blog::lists('name', 'id'), old('blog_id') , ['class'=>'form-control select2']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('status', 'Status: ') !!}
            {!! Form::select('status', ['0'=>'Waiting for approval', '1'=>'Published'], old('status') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('is_reply', 'Is reply: ') !!}
            {!! Form::select('is_reply', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('is_reply') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('from', 'From: ') !!}
            {!! Form::text('from', old('from') , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('to', 'To: ') !!}
            {!! Form::text('to', old('to') , ['class'=>'form-control datepicker']) !!}
        </div>

        {!! Form::submit('search', ['class'=>'btn btn-info']) !!}
        
    {!! Form::close() !!}
    
    <hr>
</section>



@if($errors->any())
<section class="col-sm-10 col-sm-offset-1 panel-body">
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
    
    <a href="{{action('Comments@create')}}" class="btn btn-default pull-right btn-lg blue-border blue-text">Add new</a>
    
    <table class="table table-responsive">
        <thead>
            <tr>
				<th class="blue-bg white-text">Id</th>
				<th class="blue-bg white-text">Comment</th>
				<th class="blue-bg white-text">Status</th>
				<th class="blue-bg white-text">Created at</th>
				<th class="blue-bg white-text">Updated at</th>
                <th class="blue-bg white-text" width="50">Modify</th>
                <th class="blue-bg white-text" width="50">Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($comments)
                @foreach($comments as $comment)
                    <tr>
						<td>{{$comment->id}}</td>
						<td>{{$comment->name}}</td>
						<td>
						    @if($comment->status == 1)
                            <a href="{{action('Comments@unpublish', $comment->id)}}" class="badge badge-success">Published</a>
                            @elseif($comment->status == 0)
                            <a href="{{action('Comments@publish', $comment->id)}}" class="badge badge-warning">UnPublished</a>
                            @endif
						</td>
						<td>{{$comment->created_at}}</td>
						<td>{{$comment->updated_at}}</td>
                        <td>
                            {!! edits('Comments', $comment['id'], '<span class=\'fa fa-pencil\'></span>', ['class'=>'btn btn-warning btn-rounded']) !!}
                        </td>
                        <td>
                            {!! deletes('Comments', $comment['id'], '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $comments->render() !!}
</section>


@stop
        