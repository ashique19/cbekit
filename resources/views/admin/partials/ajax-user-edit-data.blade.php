<div class="box">
    
    {!! Form::open(['url' => action('AdminUsers@updateUserData', $user->id), 'class'=>'columns is-multiline']) !!}
    
    <div class="column is-12-desktop is-12-mobile">
        <div class="field">
            <h3 class="subtitle is-3">
                Edit - {{ $user->name }}
                <br>
                <small class="font-size-12">Email: {{ $user->email }}</small>
            </h3>
        </div>
    </div>
    
    @if( $user->role == 5 )
    <div class="column is-12-desktop is-12-mobile">
        <div class="field">
            <div class="control">
                {!! Form::text('institute_name', $user->institute_name, ['class'=>'input', 'placeholder'=>'Institute name', 'required'=>'']) !!}
            </div>
        </div>
    </div>
    @endif
    
    <div class="column is-6-desktop is-12-mobile">
        <div class="field">
            <div class="control">
                {!! Form::text('firstname', $user->firstname, ['class'=>'input', 'placeholder'=>'First name', 'required'=>'']) !!}
            </div>
        </div>
    </div>
    
    <div class="column is-6-desktop is-12-mobile">
        <div class="field">
            <div class="control">
                {!! Form::text('lastname', $user->lastname, ['class'=>'input', 'placeholder'=>'Last name', 'required'=>'']) !!}
            </div>
        </div>
    </div>
    
    <div class="column is-6-desktop is-12-mobile">
        <div class="field">
            <div class="control">
                <div class="select is-fullwidth">
                    @if( auth()->user()->role == 1 )
                    {!! Form::select('role', [2=>'Admin', 3=>'Student', 4=>'Teacher'], $user->role, ['class'=>'form-control', 'placeholder'=>'-Type-', 'required'=>'']) !!}
                    @else
                    {!! Form::select('role', [3=>'Student', 4=>'Teacher'], $user->role, ['class'=>'form-control', 'placeholder'=>'-Type-', 'required'=>'']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="column is-6-desktop is-12-mobile">
        <div class="field">
            <div class="control">
                <div class="select">
                    {!! Form::select('country_id', \App\Country::pluck('name','id'), $user->country_id ?: 18, ['placeholder'=> '-Country-', 'class'=>'form-control', 'required'=>'']) !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="column is-12-desktop is-12-mobile">
        <div class="field">
            <div class="control">
                {!! Form::text('address', $user->address, ['class'=>'input', 'placeholder'=>'Address', 'required'=>'']) !!}
            </div>
        </div>
    </div>
    
    <div class="column is-6-desktop is-6-mobile">
        <div class="field">
            <div class="control">
                {!! Form::text('contact', $user->contact, ['class'=>'input', 'placeholder'=>'Phone no.', 'required'=>'']) !!}
            </div>
        </div>
    </div>
    
    <div class="column is-6-desktop is-6-mobile">
        <div class="field">
            <div class="control">
                {!! Form::password('password', ['class'=>'input', 'placeholder'=>'Password (leave blank to keep unchanged)']) !!}
            </div>
        </div>
    </div>
    
    <div class="column is-12 is-mobile">
        <div class="field is-grouped is-grouped-centered">
            <p class="control">
                <button class="button is-info" type="submit">Save</button>
            </p>
        </div>
    </div>
    
    @if( $user->active == 2 )
    <div class="column is-12 is-mobile">
        <div class="field is-grouped is-grouped-centered">
            <p class="control">
                <p class="text-center">
                    <a href="#" class="btn btn-xs has-text-info" data-toggle="modal" data-target="#resend-verification-email">Resend Verification Email</a>
                </p>
            </p>
        </div>
    </div>
    
    @endif
    
    {!! Form::close() !!}
    
    @if($user->active == 2)
    
    <div class="modal fade modal-centered" id="resend-verification-email" tabindex="-1" role="dialog" aria-labelledby="resend-verification-email">
        <div class="modal-dialog modal-md" role="document">
            <div class="blue-bg col-xs-12 white-text padding-100">
                
                {!! Form::open(['method'=>'post', 'url'=>action('AccessController@resendVerificationEmail'), 'role'=>'form']) !!}
                
                <div class="modal-header col-xs-12 padding-left-0 padding-right-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-uppercase" id="myModalLabel">Resend Verification Email</h4>
                </div>
                
                <div class="modal-body col-xs-12 padding-left-0 padding-right-0">
                    
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            {!! Form::email('email', $user->email, ['class'=>'input is-white', 'placeholder'=>'Enter your email address', 'required'=>'', 'aria-describedby'=> 'resend verification email']) !!}
                        </div>
                        <div class="control">
                            <button class="button is-white is-outlined" type="submit">
                            Submit
                            </button>
                        </div>
                    </div>
                    
                    
                </div>
                
                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
    
    
    @endif
    
</div>
