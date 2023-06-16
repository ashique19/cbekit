@extends('admin.layout')

@section('main')

<h3>Roles</h3>


@if($errors)

    {{$errors->first()}}

@endif


<table class="table">
    <thead>
        <tr>
            <th>Serial</th>
            <th>Name</th>
            <th>Modify</th>
            <th>Delete</th>
            <th>Navs</th>
            <th>Permission</th>
        </tr>
    </thead>
    <tbody>
        @if($roles)
            @foreach($roles as $role)
                <tr>
                    <td>{{$role['id']}}</td>
                    <td>{{$role['name']}}</td>
                    <td>
                        <a href="{{action('Roles@edit', $role['id'])}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                    </td>
                    <td>
                        {!! Form::open(['method'=>'delete', 'url'=> "admin/roles/".$role['id'] ]) !!}
                        {!! Form::hidden('id', $role['id'] ) !!}
                        <button href="{{action('Roles@edit',[$role['id']])}}" class="btn btn-danger btn-sm btn-rounded" title="Delete role">
                            <span class="fa fa-times"></span>
                        </button>
                        {!! Form::close() !!}
                    </td>
                    <td>
                        <a href="{{action('Roles@navs',[$role['id']])}}" class="btn btn-info btn-sm btn-rounded" title="Edit role"><span class="fa fa-road"></span></a>
                    </td>
                    <td>
                        <a href="{{action('Roles@permissions',[$role['id']])}}" class="btn btn-warning btn-sm btn-rounded" title="Edit role"><span class="fa fa-adjust"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@stop