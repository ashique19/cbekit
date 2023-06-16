
@extends('admin.layout')

@section('title') Blog @stop

@section('main')

<h1><center>Blogs @if($blogs) : {{$blogs->total()}} @endif</center></h1>

<section class="col-sm-10 col-sm-offset-1">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Blogs@searchIndex')]) !!} 
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('status', 'Status: ') !!}
            {!! Form::select('status', ['0'=>'Draft', '1'=>'Waiting for approval', '2'=>'Published', '3'=>'Trashed'], old('status') , ['class'=>'form-control']) !!}
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
    
    <a href="{{action('Blogs@create')}}" class="btn btn-default pull-right btn-lg blue-border blue-text">Add new</a>
    
    <table class="table table-responsive">
        <thead>
            <tr>
				<th class="blue-bg white-text">Id</th>
				<th class="blue-bg white-text">Name</th>
				<th class="blue-bg white-text">Banner photo</th>
				<th class="blue-bg white-text">Updated by</th>
				<th class="blue-bg white-text">Status</th>
				<th class="blue-bg white-text">Updated at</th>
                <th class="blue-bg white-text" width="50">Show</th>
                <th class="blue-bg white-text" width="50">Modify</th>
                <th class="blue-bg white-text" width="50">Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($blogs)
                @foreach($blogs as $blog)
                    <tr>
						<td>{{$blog->id}}</td>
						<td>{{$blog->name}}</td>
						<td><center><a href="{{$blog->banner_photo}}" class="btn btn-default btn-xs"><img src="{{$blog->banner_photo}}" width="100" height="70" ></a></center></td>
						<td>@if($blog->updatedBy){{$blog->updatedBy->name}} @endif</td>
						<td>@if($blog->status == 0)Draft @elseif($blog->status == 1) Waiting for Approval @elseif($blog->status == 2)Published @elseif($blog->status == 3)Trash @endif</td>
						<td>{{$blog->updated_at}}</td>
                        <td>
                            {!! views('Blogs', $blog->id, '<span class=\'fa fa-expand\'></span>', ['class'=>'btn btn-success btn-rounded']) !!}
                        </td>
                        <td>
                            {!! edits('Blogs', $blog['id'], '<span class=\'fa fa-pencil\'></span>', ['class'=>'btn btn-warning btn-rounded']) !!}
                        </td>
                        <td>
                            {!! deletes('Blogs', $blog['id'], '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $blogs->render() !!}
</section>


@stop
        