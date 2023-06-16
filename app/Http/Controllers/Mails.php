<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;
// use App\Http\Controllers\Controller;
use App\User;
use Mail;

class Mails extends Controller
{
    
    public function signup($id)
    {
        
        $user = User::find($id);
        if($user)
        {
            switch($user->role)
            { 
                
                case 1:
                        Mail::send('mails.clientSignup', ['user'=>$user], function ($message) use ($user) {
                            $message->to($user->email, $user->firstname.$user->lastname);
                    	    $message->from('info@teamsourcing.com.bd', 'TeamSourcing Admin');
                    	    $message->subject('Welcome to TeamSourcing Bangladesh');
                    	    
                    	});
                    	
                    	
                    	if($user->referrer_id)
                    	{
                    	    
                    	    if(User::where('id',$user->referrer_id)->first())
                    	    {
                    	        $referrer = User::where('id',$user->referrer_id)->first();
                    	        
                    	        Mail::send('mails.clientSignupInfoToReferrer', ['user'=>$user, 'referrer'=>$referrer], function ($message) use ($user,$referrer) {
                                    $message->to($referrer->email, $referrer->firstname.$referrer->lastname);
                            	    $message->from('info@teamsourcing.com.bd', 'TeamSourcing Admin');
                            	    $message->subject('You have a new client at TeamSourcing (Bangladesh)');
                            	    
                            	});
                            	
                    	        
                    	    }
                    	    
                    	}
                    	
                    	//return view('mails.clientSignupInfoToReferrer',['user'=>$user, 'referrer'=>$referrer]);
                        break;
                case 2:
                    break;
                case 3:
                    // Student
                    Mail::send('mails.clientSignup', ['user'=>$user], function ($message) use ($user) {
                        $message->subject('Welcome to '.settings()->application_name );
                        $message->to($user->email, $user->firstname." ".$user->lastname);
                        $message->bcc('ashique19@gmail.com', 'dev team');
                        $message->from( env('EMAIL_DO_NOT_REPLY') , settings()->application_name );
                    });
                    break;
                case 4:
                    // Teacher
                    Mail::send('mails.clientSignup', ['user'=>$user], function ($message) use ($user) {
                        $message->to($user->email, $user->firstname." ".$user->lastname);
                        $message->subject('Welcome to '.settings()->application_name );
                        $message->bcc('ashique19@gmail.com', 'dev team');
                        $message->from( env('EMAIL_DO_NOT_REPLY') , settings()->application_name );
                    });
                    
                    break;
                case 5:
                    
                    break;
                case 6:
                        
                    	
                    	
                    break;
                default:
                    break;
                
            }
            
            
        }
        
    }
    
    
    public function accountActivation($id)
    {
        
        $user = User::where('id',$id)->first();
        
        if($user)
        {
            
            Mail::send('mails.clientAccountActivationConfirmation', ['user'=>$user], function ($message) use ($user) {
                $message->to($user->email, $user->firstname." ".$user->lastname);
                $message->subject('Welcome to '.settings()->application_name );
                $message->bcc('ashique19@gmail.com', 'dev team');
                $message->from( env('EMAIL_DO_NOT_REPLY') , settings()->application_name );
        	});
            
        }
        
    }
    
    
    public function forgotPassword($id, $new_password)
    {
        
        if($user = User::find($id)){
            
            
            Mail::send('mails.forgotPassword', ['user' => $user, 'new_password'=>$new_password], function ($m) use ($user) {
                $m->to($user->email, $user->firstname." ".$user->lastname)
                  ->subject('Password Recovery')
                  ->from('ashique19@gmail.com', 'Admin');
            });
            
        }
        
    }
    
    
    public function contactToAdmin($request)
    {
        
        Mail::send('mails.contact-to-admin', ['request'=>$request], function ($message) use ($request) {
                            $message->to( env('EMAIL_INFO') , 'To whom it may concern')
                                    ->from( env('EMAIL_SYS') , 'Notification System')
                    	            ->subject('New Contact Request has arrived');
                    	    
                    	});
        
    }
    
    
    public function emailVerification($user, $verification_code)
    {
        
        // return view('mails.email-verification', ['user'=>$user, 'verification_code'=>$verification_code]);
        
        Mail::send('mails.email-verification', ['user'=>$user, 'verification_code'=>$verification_code], function ($message) use ($user) {
            $message->to($user->email, $user->firstname." ".$user->lastname);
                $message->subject('Welcome to '.settings()->application_name );
                $message->bcc('ashique19@gmail.com', 'dev team');
                $message->from( env('EMAIL_DO_NOT_REPLY') , settings()->application_name );
        });
        
        
    }
    
    
    public function signupEmailVerified($user)
    {
        
        Mail::send('mails.signup-email-verified', ['user'=>$user], function ($m) use ($user) {
            $m->to($user->email, $user->firstname." ".$user->lastname)
              ->subject('Thank you for veriying your email')
              ->from(env('MAIL_INFO'), settings()->application_name)
              ->bcc('ashique19@gmail.com', 'Dev');
        });
        
        
    }
    
    
    public function userActivated($user)
    {
        
        Mail::send('mails.user-activated', ['user'=>$user], function ($m) use ($user) {
            $m->to($user->email, $user->firstname." ".$user->lastname)
              ->subject('Your account has been activated')
              ->from(env('MAIL_INFO'), settings()->application_name)
              ->bcc('ashique19@gmail.com', 'Dev');
        });
        
        
    }
   
    
}
