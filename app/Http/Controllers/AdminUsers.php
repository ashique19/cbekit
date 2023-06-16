<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUsers extends Controller
{
    
    
    public function getAjaxEditData($id)
    {
        
        if( auth()->user()->role != 2 ) return back()->withErrors('unauthorized attempt. your IP has been noted.');
        
        $user = User::find( $id );
        
        if( ! $user ) return back()->withErrors('User was not found');
        
        return view('admin.partials.ajax-user-edit-data', compact('user') );
        
    }
    
    
    public function updateUserData(Request $request, $id)
    {
        
        $this->validate($request, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'country_id'=> 'required',
            'address'   => 'required|min:10',
            'contact'   => 'required|min:11',
        ]);

        if( $request->has('institute_name') )
        {

            if( strlen( $request->input('institute_name') ) < 4 ) return back()->withErrors('Institute name cannot be blank.');

        }
        
        if( strlen($request->input('password')) < 4 ) unset($request['password']);
        
        unset($request['_token']);
        
        $request['name'] = $request->input('firstname').' '.$request->input('lastname');
        
        if( !in_array( auth()->user()->role, [1,2] ) ) return back()->withErrors('unauthorized attempt. your IP has been noted.');
        
        $user = User::find( $id );
        
        if( User::where('id', $id)->update( $request->all() ) )
        {
            
            if( strlen($request->input('password')) > 3 ) \DB::table('users')->update(['password' => bcrypt($request->input('password')) ]) ;
            
            return back()->withErrors('user data has been updated successfully.');
            
        }
        
        if( ! $user ) return back()->withErrors('User was not found');
        
        
        
    }
    
    
    public function manuallyVerifyUser( $code )
    {
        
        if( strlen( $code ) < 41 ) return back()->withErrors('Invalid verification code.');
        
        $user_id = substr( substr($code, 40), 0,  strlen($code)-60 );
        
        $user = User::where( 'id', $user_id )->where('active',2)->first();
        
        if( $user )
        {
            
            User::where('id', $user_id)->update(['active'=>3]);
            
            ( new Mails )->signupEmailVerified( User::find( $user_id ) );
            
            return redirect()->route('login')->withErrors('Thank you for verifying your email. We will process your application within next 2 working days.');
            
        } else{
            
            return back()->withErrors('User was not found in system');
            
        }
        
        return back()->withErrors('User email has been verified.');
        
    }
    
    
    
    public function activateUser( $code )
    {
        
        if( strlen( $code ) < 41 ) return back()->withErrors('Invalid verification code.');
        
        $user_id = substr( substr($code, 40), 0,  strlen($code)-60 );
        
        $user = User::where( 'id', $user_id )->where('active',3)->first();
        
        if( $user )
        {
            
            User::where('id', $user_id)->update(['active'=>1]);
            
            ( new Mails )->userActivated( User::find( $user_id ) );
            
        } else{
            
            return back()->withErrors('User was not found in system');
            
        }
        
        return back()->withErrors('User has been activated.');
        
    }
    
    
    
    public function reactivateUser( $code )
    {
        
        if( strlen( $code ) < 41 ) return back()->withErrors('Invalid verification code.');
        
        $user_id = substr( substr($code, 40), 0,  strlen($code)-60 );
        
        $user = User::where( 'id', $user_id )->where('active',0)->first();
        
        if( $user )
        {
            
            User::where('id', $user_id)->update(['active'=>1]);
            
            ( new Mails )->userActivated( User::find( $user_id ) );
            
        } else{
            
            return back()->withErrors('User was not found in system');
            
        }
        
        return back()->withErrors('User has been activated.');
        
    }
    
    
    
    public function deactivateUser( $code )
    {
        
        if( strlen( $code ) < 41 ) return back()->withErrors('Invalid verification code.');
        
        $user_id = substr( substr($code, 40), 0,  strlen($code)-60 );
        
        $user = User::where( 'id', $user_id )->first();
        
        if( $user )
        {
            
            User::where('id', $user_id)->update(['active'=>0]);
            
            // ( new Mails )->userActivated( User::find( $user_id ) );
            
        } else{
            
            return back()->withErrors('User was not found in system');
            
        }
        
        return back()->withErrors('User has been de-activated.');
        
    }
    
    
    
    public function emailUnverified()
    {
        
        $users = User::where('active', 2)->paginate(30);
        
        return view('admin.admin-users.email-unverified', compact('users') );
        
    }
    
    
    public function activationPending()
    {
        
        $users = User::where('active', 3)->paginate(30);
        
        return view('admin.admin-users.pending-activation', compact('users') );
        
    }
    
    public function inactive()
    {
        
        $users = User::where('active', 0)->paginate(30);
        
        return view('admin.admin-users.deactivated-users', compact('users') );
        
    }
    
    public function student()
    {
        
        $users = User::where('active', 1)->where('role', 3)->paginate(30);
        
        return view('admin.admin-users.student', compact('users') );
        
    }
    
    public function teacher()
    {
        
        $users = User::where('active', 1)->where('role', 4)->paginate(30);
        
        return view('admin.admin-users.teacher', compact('users') );
        
    }
    
    public function institute()
    {
        
        $users = User::where('active', 1)->where('role', 5)->paginate(30);
        
        return view('admin.admin-users.institute', compact('users') );
        
    }
    
}
