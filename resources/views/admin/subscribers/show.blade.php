
@extends('admin.layout')

@section('title') Subscriber @stop

@section('main')

<h1 class="page-title"><center>Subscriber</center></h1>

{!! errors($errors) !!}

@if($subscriber)
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
                    <td>{{$subscriber->id}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$subscriber->name}}</td>
                </tr>
                
                <tr>
                    <td>Email</td>
                    <td>{{$subscriber->email}}</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$subscriber->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$subscriber->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    {!! edits('Subscribers', $subscriber->id, 'edit', ['class'=>'btn btn-warning btn-rounded']) !!}
                            
                </td>
                <td>
                    {!! deletes('Subscribers', $subscriber->id, '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>

@else

    <h3>No data found.</h3>

@endif

@stop
        