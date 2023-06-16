@extends('admin.layout')

@section('main')

<article class="columns is-multiline">
    
    <aside class="column is-12-desktop is-12-mobile">

        <h3 class="subtitle is-4">Modify User: {{$user->name}}</h3>
    
    </aside>
    
    <main class="column is-12-desktop is-12-table is-12-mobile">
    
    {!! Form::open( ['method'=>'patch', 'url'=> action('Users@update', ['id'=>$user->id]), 'enctype'=>'multipart/form-data' ]) !!}
    
        <div class="form-group">
            {!! Form::label('firstname','First Name: ') !!}
            {!! Form::text('firstname', $user->firstname , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('lastname','Last Name: ') !!}
            {!! Form::text('lastname', $user->lastname , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('email','Email: ') !!}
            {!! Form::text('email', $user->email , ['class'=>'form-control']) !!}
        </div>
        
        
        <div class="form-group">
            {!! Form::label('password','New Password: ') !!}
            {!! Form::text('password', null , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('address','Address: ') !!}
            {!! Form::text('address', $user->address , ['class'=>'form-control']) !!}
        </div>
        
        
        <div class="form-group">
            {!! Form::label('contact','Contact: ') !!}
            {!! Form::text('contact', $user->contact , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('role','Role: ') !!}
            {!! Form::select('role', $roles, $user->role , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('address','Address: ') !!}
            {!! Form::text('address', $user->address , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('city','City: ') !!}
            {!! Form::text('city', $user->city , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('state','State: ') !!}
            {!! Form::text('state', $user->state , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('postcode','Postcode: ') !!}
            {!! Form::text('postcode', $user->postcode , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('country_id','Country: ') !!}
            {!! Form::select('country_id', \App\Country::pluck('name','id'), $user->country_id , ['class'=>'form-control select2']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('parmanent_address','Parmanent Address: ') !!}
            {!! Form::text('parmanent_address', $user->parmanent_address , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('expiry_date','Expiry date: ') !!}
            {!! Form::text('expiry_date', $user->expiry_date , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('active','Status: ') !!}
            {!! Form::select('active', ['0'=>'inactive','1'=>'Active', '2'=>'email verification pending', '3'=>'activation penfing'], $user->active , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('balance','Balance: ') !!}
            {!! Form::text('balance', $user->balance , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('picture','New Photo: ') !!}
            {!! Form::file('picture' , ['class'=>'form-control']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::submit('Update User', ['class'=>'form-control btn btn-info']) !!}
        </div>
    
    {!! Form::close() !!}
    
    </main>
    
    
</article>

@stop