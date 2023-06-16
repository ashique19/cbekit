@extends('admin.layout')

@section('main')

<section class="container">
    
<h3>Create new User</h3>

@if($errors->any())
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>

@endif

{!! Form::open(['action'=>'Users@store', 'role'=>'form', 'class'=>'form', 'enctype'=>'multipart/form-data' ]) !!}

    <div class="form-group">
        {!! Form::label('firstname','First Name: ') !!}
        {!! Form::text('firstname', old('firstname'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('lastname','Last Name: ') !!}
        {!! Form::text('lastname', old('lastname'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('email','Email: ') !!}
        {!! Form::text('email', old('email'), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password','Password: ') !!}
        {!! Form::text('password', old('password'), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('role','Role: ') !!}
        {!! Form::select('role', \App\Role::lists('name','id'), old('role'), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('address','Address: ') !!}
        {!! Form::text('address', old('address'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('city','City: ') !!}
        {!! Form::text('city', old('city'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('state','State: ') !!}
        {!! Form::text('state', old('state'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('postcode','Postcode: ') !!}
        {!! Form::text('postcode', old('postcode'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('country_id','Country: ') !!}
        {!! Form::select('country_id', \App\Country::lists('name','id'), old('country_id'), ['class'=>'form-control select2']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('parmanent_address','Parmanent Address: ') !!}
        {!! Form::text('parmanent_address', old('parmanent_address'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('postcode','Postcode: ') !!}
        {!! Form::text('postcode', old('postcode'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('active','Status: ') !!}
        {!! Form::select('active', ['1'=>'Active', '2'=>'Inactive', '3'=>'Unverified'], old('active'), ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('balance','Balance: ') !!}
        {!! Form::text('balance', old('balance'), ['class'=> 'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('picture','Photo: ') !!}
        {!! Form::file('picture', ['class'=> 'form-control'] ) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('expiry_date','Expiry date: ') !!}
        {!! Form::text('expiry_date', old('expiry_date'), ['class'=> 'form-control datepicker']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Add User', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}



</section>

@stop