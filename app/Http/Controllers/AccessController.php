<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Socialite;
use Illuminate\Http\Request;
use App\NavRole;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mails;
use Carbon\Carbon;
use Geo;
use Validator;
use App\User;

class AccessController extends Controller
{
    
    public function login()
    {
        if( Auth::user() )
        {
            
            return redirect()->route('dashboard');
        
        } else{
            
            return view('public.pages.login');
            
        }
    }
    
    
    public function postLogin(Request $request, NavRole $navrole)
    {
        // return $request->all();
        if( strlen($request->input('username_or_email')) < 5 )
        {
            
            return redirect()->route('login')->withErrors('Please enter a valid username or email');
            
        }
        
        $user   = User::where('email', $request->input('username_or_email'))->first() ?: User::where('username', $request->input('username_or_email'))->first();
        
        if($user)
        {
            
            if($user->active != 1)
            {
                return back()->withErrors('Your account is not active. Please contact admin for help.');
            }
            
        } else{
            
            return redirect()->route('login')->withErrors('Sorry, User was not found');
            
        }
        
        
        
        if(
            Auth::attempt(['email'=>$request->input('username_or_email'),'password'=>$request->input('password'), 'active' => 1])
            ||
            Auth::attempt(['username'=>$request->input('username_or_email'),'password'=>$request->input('password'), 'active' => 1])
        )
        {
            
            $permissions    = auth()->user()->roles()->first()->permissions()->pluck('permissions.name','permissions.id');
            
            session(['permissions' => $permissions]);
            
            return redirect()->route('dashboard');
            
        } else{
            
            return redirect()->route('login')->withErrors('authentication failed')->withInput();
            
        }
        
    }
    
    
    public function logout()
    {
    
        Auth::logout();
        
        session()->forget('user_type');
        
        return redirect()->route('login');
        
    }
    
    
    public function forgotPassword()
    {
        
        return back();
        
    }
    
    
    public function postForgotPassword(Request $request, Mails $mail)
    {

        $this->validate($request, [
            'recovery_email' => 'required|email'
        ]);

        $email  = $request->input('recovery_email');
        
        $user = \App\User::where('email',$email)->first();
        
        if($user)
        {
            
            $new_password = date('YMD').rand(10000,20000);

            $user->password = $new_password;
            
            $user->save();
            
            $mail->forgotPassword($user->id, $new_password);
            
            return redirect()->route('login')->withErrors('A new password has been sent to your email address.');
        
        } else{
            
            return redirect()->route('login')->withErrors('Sorry! User could not be found in database.');
            
        }
        
        
        
        
    }
    
    
    public function signup()
    {
        
        return view('public.pages.signup');
        
    }
    
    
    public function postSignup(Request $request, \App\Http\Controllers\Mails $mails)
    {
        
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email|unique:users',
            'firstname' => 'required',
            'lastname'  => 'required',
            'country_id'=> 'required',
            'address'   => 'required|min:10',
            'contact'   => 'required|min:10',
            'password'  => 'required|min:8',
        ]);

        if ($validator->fails()) 
        {
            
            return redirect()
                        ->route('signup')
                        ->withErrors($validator)
                        ->withInput();
                        
        }

        $user_data = $request->all();
        
        // $user_data['active'] = 1;   // active
        $user_data['active'] = 2;   // email verification pending
        //$user_data['active'] = 3;   // waiting for review
        // $user_data['active'] = 4;   // email verification pending
        
        // $user_data['role'] = 3;     // student 
        
        $user_data['name'] = $request->input('firstname').' '.$request->input('lastname');
        
        $user = \App\User::create($user_data);
        
        if($user)
        {
            
            if($user_data['active'] == 1)
            {

                $mails->signup($user->id);
                
                return redirect()->route('login')->withErrors('Congrats! Sign up has been sucessful. Please login.');
                
            } elseif($user_data['active'] == 2)
            {

                ( new Mails )->emailVerification($user, str_random(40).$user->id.str_random(20));
                
                
                return redirect()->route('login')->withErrors('Please check your email inbox/spam/junk mail folder for verification email.');
                
            }
            elseif($user_data['active'] == 3)
            {
                
                return redirect()->route('login')->withErrors('Thank you for signing up. Please wait for your request to be reviewed.');
                
            }
            
        } else{
            
            return redirect()->route('signup')->withErrors('Failed to sign up. Please check the required data.')->withInput();
            
        }
        
        
    }
    
    
    public function resendVerificationEmail(Request $request)
    {
        
        $user = User::where('email', $request->input('email') )->first();
        
        if( ! $user ) return back()->withErrors('Email was not found in system');
        
        if( ! $user->status != 2 ) return back()->withErrors('This email is not waiting for verification.');
        
        ( new Mails )->emailVerification($user, str_random(40).$user->id.str_random(20));
        
        return redirect()->route('login')->withErrors('Please check your email inbox/spam/junk mail folder for verification email.');
        
    }
    
    
    public function verifyEmail($code)
    {
        
        if( strlen( $code ) < 41 ) return redirect()->route('login')->withErrors('Invalid verification code.');
        
        $user_id = substr( substr($code, 40), 0,  strlen($code)-60 );
        
        $user = User::where( 'id', $user_id )->where('active',2)->first();
        
        if( $user )
        {
            
            User::where('id', $user_id)->update(['active'=>3]);
            
            ( new Mails )->signupEmailVerified( User::find( $user_id ) );
            
            return redirect()->route('login')->withErrors('Thank you for verifying your email. We will process your application within next 2 working days.');
            
        }
        
        return redirect()->route('signup')->withErrors('Sorry, no such user is found for pending email verification. Please signup if you did not signup already.');
        
    }
    
    
    public function internalLogin($user, $navrole)
    {
        
        Auth::login($user);
        
        if(auth()->user())
        {
            
            // $leftnav_parent    = $navrole->auth()->parent()->leftnav()->active()->get();
            // $leftnav_child     = $navrole->auth()->child()->leftnav()->active()->get();
            
            // $topnav_parent    = $navrole->public()->parent()->topnav()->active()->get();
            // $topnav_child     = $navrole->public()->child()->topnav()->active()->get();
            
            // session(['leftnav_parent'=>$leftnav_parent, 'leftnav_child'=>$leftnav_child]);
            // session(['topnav_parent'=>$topnav_parent, 'topnav_child'=>$topnav_child]);
            
            return redirect()->route('dashboard');
            
        } else{
            
            return redirect()->route('login')->withErrors('authentication failed')->withInput();
            
        }
        
    }
    
    
    public function internalSignup($data, $navrole)
    {
        
        $user = \App\User::create($data);
        
        return $this->internalLogin($user, $navrole);
        
    }
    
    
    public function social($social, Request $request, NavRole $navrole)
    {
        // return $request->all();
        // example of $social = facebook, google, twitter... all stored at socials table at DB
        
        if($request->has('code'))
        {
            
            $user = Socialite::driver($social)->user();
            
            if( $user->email == null || strlen($user->email) < 5 || strlen($user->name) < 5 )
            {
                
                return redirect()->route('signup')->withErrors('Failed to retrieve enough data from Social to sign you up. Please fill in the form below to continue.');
                
            }
            
            $existing_user = \App\User::where('email', 'like', $user->email)->first();
            
            if(count($existing_user) > 0)
            {
                
                return $this->internalLogin($existing_user, $navrole);
                
            } else{
                
                $name = ($user->name) ? explode(' ',$user->name) : ['',''];
                
                $lastname = array_pop($name);
                
                $firstname = implode($name,' ');
                
                // GEO
                $geo_city = Geo::getCity() ?: "";
            
                $geo_state = Geo::getRegion() ?: "";
                
                $geo_postcode = Geo::getPostalCode() ?: "";
                
                $username = substr(preg_replace('/\s+/', '-', $user->name), 0, 5);
                $username .= \App\User::count() + 1;
            
                
                $signup_data = [
                    'firstname' => $firstname,
                    'lastname'  => $lastname,
                    'name'      => ($user->name) ? $user->name : "_",
                    'email'     => $user->email,
                    'username'  => $username ,
                    'contact'   => '',
                    'password'  => bcrypt(round(rand(10000, 50000))),
                    'role'      => 3,
                    'city'      => $geo_city,
                    'state'     => $geo_state,
                    'postcode'  => $geo_postcode,
                    'country_id'=> ( \App\Country::where('code', 'like', Geo::getCountryCode() )->count() > 0) ? \App\Country::where('code', 'like', Geo::getCountryCode() )->first()->id : null,
                    'user_photo'=> ($social == 'facebook') ? $user->avatar_original : '',
                    'social_id' => (\App\Social::where('name', $social)->first()) ? \App\Social::where('name', $social)->first()->id : 1,
                ];
                
                return $this->internalSignup($signup_data, $navrole);
                
            }
            
            
        }
        
        return Socialite::driver($social)->redirect();
        
    }
    
    
    public function deactivateMyAccount(Request $request)
    {
        
        \App\User::find(auth()->user()->id)->update([ 'active'=>2, 'note'=> $request->input('note') ]);
        
        $this->logout();
        
        return redirect()->route('login')->withErrors('Your account has been marked for delete. We will review your request according to our schedule.');
        
    }
 
    
}
