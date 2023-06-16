
@extends('admin.layout')

@section('title') Setting @stop

@section('main')

<h1><center>Setting</center></h1>

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

@if($setting)
<section class="col-xs-12">
    <table class="table table-bordered table-striped table-actions">
        <tdead>
            <tr>
                <td width="200">Title</td>
                <td>Details</td>
            </tr>
        </tdead>
        <tbody>
                
                <tr>
                    <td>Application name</td>
                    <td>{{$setting->application_name}}</td>
                </tr>
                
                <tr>
                    <td>Application slogan</td>
                    <td>{{$setting->application_slogan}}</td>
                </tr>
                
                <tr>
                    <td>Business name</td>
                    <td>{{$setting->business_name}}</td>
                </tr>
                
                <tr>
                    <td>Owners name</td>
                    <td>{{$setting->owners_name}}</td>
                </tr>
                
                <tr>
                    <td>Address</td>
                    <td>{{$setting->address}}</td>
                </tr>
                
                <tr>
                    <td>City</td>
                    <td>{{$setting->city}}</td>
                </tr>
                
                <tr>
                    <td>Country</td>
                    <td>{{$setting->country}}</td>
                </tr>
                
                <tr>
                    <td>Postcode</td>
                    <td>{{$setting->postcode}}</td>
                </tr>
                
                <tr>
                    <td>Contact</td>
                    <td>{{$setting->contact}}</td>
                </tr>
                
                <tr>
                    <td>Helpline</td>
                    <td>{{$setting->helpline}}</td>
                </tr>
                
                <tr>
                    <td>Helpmail</td>
                    <td>{{$setting->helpmail}}</td>
                </tr>
                
                <tr>
                    <td>Email</td>
                    <td>{{$setting->email}}</td>
                </tr>
                
                <tr>
                    <td>Logo photo</td>
                    <td><a href="{{$setting->logo_photo}}" class="btn btn-default btn-rounded btn-xs"><span class="fa fa-download"></span></a></td>
                </tr>
                
                <tr>
                    <td>Icon photo</td>
                    <td><a href="{{$setting->icon_photo}}" class="btn btn-default btn-rounded btn-xs"><span class="fa fa-download"></span></a></td>
                </tr>
                
                <tr>
                    <td>Google plus</td>
                    <td>{{$setting->google_plus}}</td>
                </tr>
                
                <tr>
                    <td>Facebook</td>
                    <td>{{$setting->facebook}}</td>
                </tr>
                
                <tr>
                    <td>Twitter</td>
                    <td>{{$setting->twitter}}</td>
                </tr>
                
                <tr>
                    <td>Is controlled access</td>
                    <td>@if($setting->is_controlled_access == 1)Yes @else No @endif</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$setting->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$setting->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    <a href="{{action('Settings@edit', $setting->id)}}" class="btn btn-info btn-sm">edit</a>                
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
</section>
@else

    <h3>No data found.</h3>

@endif

@stop
        