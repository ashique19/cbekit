
@extends('admin.layout')

@section('title') Comment @stop

@section('main')

<h1 class="page-title"><center>Comment</center></h1>


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


@if($comment)
<section class="row panel-body">
    <table class="table table-bordered table-striped table-actions">
        <tdead>
            <tr>
                <td width="200">Title</td>
                <td>Details</td>
            </tr>
        </tdead>
        <tbody>
                <tr>
                    <td>Id</td>
                    <td>{{$comment->id}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$comment->name}}</td>
                </tr>
                
                <tr>
                    <td>User</td>
                    <td>@if($comment->user) {{$comment->user->name}} @endif</td>
                </tr>
                
                <tr>
                    <td>Blog</td>
                    <td>@if($comment->blog) {{$comment->blog->name}} @endif</td>
                </tr>
                
                <tr>
                    <td>Status</td>
                    <td>{{$comment->status}}</td>
                </tr>
                
                <tr>
                    <td>Is reply</td>
                    <td>{{$comment->is_reply}}</td>
                </tr>
                
                <tr>
                    <td>Comment</td>
                    <td>@if($comment->comment) {{$comment->comment->name}} @endif</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$comment->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$comment->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    {!! edits('Comments', $comment->id, 'edit', ['class'=>'btn btn-warning btn-rounded']) !!}
                            
                </td>
                <td>
                    {!! deletes('Comments', $comment->id, '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>

@else

    <h3>No data found.</h3>

@endif

@stop
        