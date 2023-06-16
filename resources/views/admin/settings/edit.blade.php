
@extends('admin.layout')

@section('title') Edit Settings @stop

@section('main')

<h1><center>Modify Setting</center></h1>

<section class="col-xs-12">
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

{!! Form::open( ['method'=>'patch', 'url'=> action('Settings@update', $setting->id), 'enctype'=>'multipart/form-data' ]) !!}

    
            <div class="form-group">
                {!! Form::label('application_name', 'Application name: ') !!}
                {!! Form::text('application_name', $setting->application_name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('application_slogan', 'Application slogan: ') !!}
                {!! Form::text('application_slogan', $setting->application_slogan , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('business_name', 'Business name: ') !!}
                {!! Form::text('business_name', $setting->business_name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('owners_name', 'Owners name: ') !!}
                {!! Form::text('owners_name', $setting->owners_name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('address', 'Address: ') !!}
                {!! Form::text('address', $setting->address , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('city', 'City: ') !!}
                {!! Form::text('city', $setting->city , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('country', 'Country: ') !!}
                {!! Form::text('country', $setting->country , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('postcode', 'Postcode: ') !!}
                {!! Form::text('postcode', $setting->postcode , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('contact', 'Contact: ') !!}
                {!! Form::text('contact', $setting->contact , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('helpline', 'Helpline: ') !!}
                {!! Form::text('helpline', $setting->helpline , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('helpmail', 'Helpmail: ') !!}
                {!! Form::text('helpmail', $setting->helpmail , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('email', 'Email: ') !!}
                {!! Form::text('email', $setting->email , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                <label for="logo_photos">Logo photo: <span class="badge badge-primary"><input type="checkbox" value="1" name="logo_photo_delete" /> remove</span></label>
                {!! Form::file('logo_photos' , ['class'=>'form-control file']) !!}
            </div>
                
            <div class="form-group">
                <label for="icon_photos">Icon photo: <span class="badge badge-primary"><input type="checkbox" value="1" name="icon_photo_delete" /> remove</span></label>
                {!! Form::file('icon_photos' , ['class'=>'form-control file']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('google_plus', 'Google plus: ') !!}
                {!! Form::text('google_plus', $setting->google_plus , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('facebook', 'Facebook: ') !!}
                {!! Form::text('facebook', $setting->facebook , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('twitter', 'Twitter: ') !!}
                {!! Form::text('twitter', $setting->twitter , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('is_controlled_access', 'Is controlled access: ') !!}
                {!! Form::select('is_controlled_access', [ ''=>'-Select-','1'=>'Yes', '2'=>'No'], $setting->is_controlled_access , ['class'=>'form-control']) !!}
            </div>
                
    <div class="form-group">
        {!! Form::submit('Update Setting', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        