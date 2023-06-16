@extends('admin.layout')

@section('title') Blogslide @stop

@section('main')

<h1><center>Blogslides @if($blogslides) : {{$blogslides->total()}} @endif</center></h1>

<section class="col-xs-12">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Blogslides@searchIndex')]) !!} 
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('subtitle', 'Subtitle: ') !!}
            {!! Form::text('subtitle', old('subtitle') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('blog_id', 'Blog: ') !!}
            {!! Form::select('blog_id', \App\Blog::lists('name', 'id'), old('blog_id') , ['class'=>'form-control select2']) !!}
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

<section class="col-sm-11">
@if($errors->any())

    <h4>Please check:</h4>
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>
    <hr>
    
@endif
</section>

<section class="col-sm-11">
    <h2>
        <a class="btn btn-warning pull-right" href="{{action('Blogs@blogslidesCreate', $blog->id)}}">Create new blogslide</a>
        <br>
    </h2>
    
    <table class="table table-responsive">
        <thead>
            <tr>
				<th>Id</th>
				<th>Name</th>
				<th>Subtitle</th>
				<th>Slide photo</th>
				<th>Blog</th>
				<th>Created at</th>
				<th>Updated at</th>
                <th>Show</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($blogslides)
                @foreach($blogslides as $blogslide)
                    <tr>
						<td>{{$blogslide->id}}</td>
						<td>{{$blogslide->name}}</td>
						<td>{{$blogslide->subtitle}}</td>
						<td><center><a href="{{$blogslide->slide_photo}}" class="btn btn-default btn-xs"><img src="{{$blogslide->slide_photo}}" width="100" height="70" ></a></center></td>
						<td>@if($blogslide->blog) {{$blogslide->blog->name}} @endif</td>
						<td>{{$blogslide->created_at}}</td>
						<td>{{$blogslide->updated_at}}</td>
                        <td>
                            <a href="{{action('Blogslides@show', $blogslide->id)}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            <a href="{{action('Blogslides@edit', $blogslide['id'])}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'delete', 'url'=> action('Blogslides@destroy', $blogslide->id) ]) !!}
                            {!! Form::hidden('id', $blogslide->id ) !!}
                            <button href="{{action('Blogslides@edit',[$blogslide->id])}}" class="btn btn-danger btn-sm btn-rounded" title="Delete blogslide ">
                                <span class="fa fa-times"></span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $blogslides->render() !!}
</section>

@stop
        