@extends('public.layouts.layout')
@section('title')
{{settings()->application_name}}-@if($singleBlog){{$singleBlog->name}} @endif 
@stop

@section('main')

<section class="col-xs-12 main-body">
    
    <div class="panel panel-default"></div>
    
    @if($singleBlog)
    
    <div class="panel panel-default">
        
        <h2 class="page-title"><center>{{$singleBlog->name}}</center></h2>
        
        <div class="panel-body">
            <img src="{{$singleBlog->banner_photo}}" alt="" class="img-responsive">
        </div>
        <div class="panel-body posts">
            {!! $singleBlog->details !!}
        </div>
        
        <div class="panel-body posts">
            <h3 class="page-title">Comments</h3>
            <ul class="media-list">
                @if($comments)
                    @foreach($comments as $comment)
                    <li class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-text" src="@if($comment->user) {{$comment->user->user_photo}} @endif" alt="@if($comment->user) {{$comment->user->name}} @endif" width="64" >
                        </a>
                        <a data-toggle="collapse" href="#reply{{$comment->id}}" aria-expanded="false" aria-controls="reply{{$comment->id}}" role="button" class="btn btn-primary btn-rounded pull-right"><i class="fa fa-mail-reply"></i> Reply</a>
                        <div class="media-body">
                            <h4 class="media-heading">@if($comment->user) {{$comment->user->name}} @endif</h4>
                            <p>{{$comment->name}}</p>
                            <p class="text-muted">{{$comment->created_at}}</p>
                            <div class="panel-body collapse" id="reply{{$comment->id}}">
                                
                                {!! Form::open(['url'=> action('Blogs@commentReplyStore', ['id'=>$singleBlog->id, 'comment'=>$comment->id]) ]) !!}
                                <div class="col-xs-12">
                                    {!! Form::textarea('name', old('name'), ['class'=>'form-control']) !!}
                                </div>
                                <div class="col-xs-12">
                                    {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-rounded btn-xs push-up-10']) !!}
                                </div>
                                {!! Form::close() !!}
                                
                            </div>
                            @if($comment->reply($comment->id)->published()->count() > 0)
                                @foreach($comment->reply($comment->id)->published()->get() as $reply)
                                    <div class="media">
                                        <a class="pull-left" href="#">
                                            <img class="media-object img-text" src="@if($reply->user) {{$reply->user->user_photo}} @endif" alt="@if($reply->user) {{$reply->user->name}} @endif" width="32">
                                        </a>
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
            <br>
            <h3 class="page-title">Make a Comment</h3>
            @if(!auth()->user())
            <div class="col-xs-12 push-down-20">
            <a href="{{route('login')}}" class="badge badge-danger">Please login to comment</a>
            </div>
            @endif
            {!! Form::open(['url'=>action('Blogs@commentStore', $singleBlog->id)]) !!}
            
            <div class="col-xs-12 push-down-20">
            {!! Form::textarea('name', old('name'), ['class'=>'form-control']) !!}
            </div>
            
            <div class="col-xs-12">
            {!! Form::submit('Submit', ['class'=> 'btn btn-info pull-right']) !!}
            </div>
            
            {!! Form::close() !!}
        </div>
        
    </div>
    
    
        
    @else
    
    <!--If the Page does not exist, we say sorry! -->
    
    <div class="panel panel-default">
        <h2 class="page-title"><center>Sorry! The page you are looking for, does not exist..</center></h2>
        <strong><center>Come again later to see if it exists or <a href="{{route('home')}}">checkout our collection</a>.</center></strong>
    </div>
    
    @endif
        
</section>

@stop
        