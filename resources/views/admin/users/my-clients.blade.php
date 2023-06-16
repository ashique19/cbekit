@extends('admin.layout')

@section('main')

<section class="com-xs-12">

<h2>My clients</h2>


@if($errors->any())

    <h4>Please check:</h4>
    
    @foreach($errors->all() as $error)
    
        <li>{{$error}}</li>
    
    @endforeach
    
    <hr>
    
@endif

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Business</th>
            <th>Email</th>
            <th>State</th>
            <th>Country</th>
            <th>Grade</th>
            <th>Resume Permission</th>
            <th>Status</th>
            <th>Expiry</th>
            <th>Modify</th>
        </tr>
    </thead>
    <tbody>
        @if($users)
            @foreach($users as $user)
                
                <tr>
                    <td>{{$user->firstname}} {{$user->lastname}}</td>
                    <td>{{$user->business_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->state}}</td>
                    <td>{{$user->country}}</td>
                    <td>@if($user->clientgrade) {{$user->clientgrade->name}} @endif</td>
                    <td>@if($user->resumepermission) {{$user->resumepermission->name}} @endif</td>
                    <td>@if($user->active == 1) Active @else Inactive @endif</td>
                    <td>{{$user->expiry_date->diffForHumans()}}</td>
                    <td><a href="#" class="btn btn-info btn-sm mb-control modify_client" data-box="#modify-my-client" client_id="{{$user->id}}" grade_id="@if($user->clientgrade){{$user->clientgrade->id}}@endif" resumepermission_id="@if($user->resumepermission){{$user->resumepermission->id}}@endif"><i class="fa fa-edit"></i></a></td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{$users->render()}}

</section>

<section class="col-xs-12">
    <div class="message-box animated fadeIn" id="modify-my-client">
        <div class="mb-container">
            {!! Form::open(['url'=> action('Tempo@clientGrades')]) !!}
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-globe"></span>Modify <strong>{{$user->firstname}} {{$user->lastname}}</strong></div>
                <div class="mb-content">
                    <div class="form-group">
                        {!! Form::label('clientgrade_id', 'Grade of client') !!}
                        {!! Form::select('clientgrade_id', $clientgrades, null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('resumepermission_id', 'Resume permission') !!}
                        {!! Form::select('resumepermission_id', $resumepermission, null, ['class'=>'form-control']) !!}
                    </div>
                    {!! Form::hidden('client_id', null, ['id'=>'clientid']) !!}
                </div>
                <div class="mb-footer">
                    {!! Form::submit('Submit', ['class'=>'btn btn-info btn-lg pull-right']) !!}
                    <button class="btn btn-info btn-lg pull-right mb-control-close">Close</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@stop