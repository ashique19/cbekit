
@extends('admin.layout')

@section('title') Blog @stop

@section('main')

<h1 class="page-title"><center>Blog @if($blog)- {{$blog->name}} @endif</center></h1>


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


@if($blog)

<section class="row panel-body">
    <div class="col-xs-12">
        
        {!! deletes('Blogs', $blog->id, '<span class=\'fa fa-times\'></span> Delete this blog', ['class'=>'btn btn-danger btn-rounded pull-right']) !!}
        {!! edits('Blogs', $blog->id, '<span class=\'fa fa-pencil\'></span> Edit Blog', ['class'=>'btn btn-warning btn-rounded pull-right']) !!}
    </div>
    <ul class="list-group border-bottom col-sm-4">
        <li class="list-group-item"><i class="fa fa-angle-right"></i> ID: {{$blog->id}}</li>
        <li class="list-group-item"><i class="fa fa-angle-right"></i> <a href="{!! action('StaticPageController@singleBlog', $blog->link) !!}" class="btn btn-info btn-rounded">Public link</a></li>
        <li class="list-group-item"><i class="fa fa-angle-right"></i> Status: @if($blog->status ==0)Draft @elseif($blog->status ==1)Waiting for Approval @elseif($blog->status ==2)Published @elseif($blog->status ==3)Trashed @endif</li>
    </ul>
    <ul class="list-group border-bottom col-sm-8">
        <li class="list-group-item"><i class="fa fa-angle-right"></i> 
            <a href="{{action('Blogs@blogslides', $blog->id)}}" class="btn btn-info btn-sm">Slides</a>
            <a href="{{action('Blogs@blogslidesCreate', $blog->id)}}" class="btn btn-info btn-sm">Add Slide</a>
            <a href="{{action('Blogs@comments', $blog->id)}}" class="btn btn-info btn-sm">Comments</a>
        </li>
        <li class="list-group-item"><i class="fa fa-angle-right"></i> Created By: @if($blog->createdBy)<strong>{{$blog->createdBy->name}}</strong> at <strong>{{$blog->created_at}}</strong> @endif</li>
        <li class="list-group-item"><i class="fa fa-angle-right"></i> Updated By: @if($blog->updatedBy)<strong>{{$blog->updatedBy->name}}</strong> at <strong>{{$blog->updated_at}}</strong> @endif</li>
    </ul>
</section>

<section class="row panel-body">
    
    <div class="col-xs-12">
        <img src="{{$blog->banner_photo}}" alt="" class="img-responsive">
    </div>
    
    <div class="col-xs-12">
        {!! $blog->details !!}
    </div>
    
</section>

@else

    <h3>No data found.</h3>

@endif

@stop
        