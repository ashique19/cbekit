@extends('admin.layout')

@section('title') Comment @stop

@section('main')

<h1><center>Comments @if($comments) : {{$comments->total()}} @endif</center></h1>



@if($errors->any())
<section class="col-sm-10 col-sm-offset-1">
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
    
    <ul class="media-list">
        @if($comments)
            @foreach($comments as $comment)
            <li class="media">
                <a class="pull-left" href="#">
                    <img class="media-object img-text" src="@if($comment->user) {{$comment->user->user_photo}} @endif" alt="@if($comment->user) {{$comment->user->name}} @endif" width="64" >
                </a>
                @if($comment->status == 1)
                <a href="{{action('Comments@unpublish', $comment->id)}}" class="badge badge-success pull-right">Published</a>
                @elseif($comment->status == 0)
                <a href="{{action('Comments@publish', $comment->id)}}" class="badge badge-warning pull-right">UnPublished</a>
                @endif
                <div class="media-body">
                    <h4 class="media-heading">@if($comment->user) {{$comment->user->name}} @endif</h4>
                    <p>{{$comment->name}}</p>
                    <p class="text-muted">{{$comment->created_at}}</p>
                    @if($comment->reply($comment->id)->count() > 0)
                        @foreach($comment->reply($comment->id)->get() as $reply)
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object img-text" src="@if($reply->user) {{$reply->user->user_photo}} @endif" alt="@if($reply->user) {{$reply->user->name}} @endif" width="32">
                                </a>
                                @if($reply->status == 1)
                                <a href="{{action('Comments@unpublish', $reply->id)}}" class="badge badge-success pull-right">Published</a>
                                @elseif($reply->status == 0)
                                <a href="{{action('Comments@publish', $reply->id)}}" class="badge badge-warning pull-right">UnPublished</a>
                                @endif
                                <div class="media-body">
                                  <h4 class="media-heading">@if($reply->user) {{$reply->user->name}} @endif</h4>
                                  <p>{{$reply->name}}</p>
                                  <p class="text-muted">{{$reply->created_at}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>                                            
            </li>
            @endforeach
        @endif
    </ul>
    
    {!! $comments->render() !!}
</section>

@stop
        