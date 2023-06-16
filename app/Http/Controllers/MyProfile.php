<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Storage;
use App\Http\Requests;
use App\Http\Requests\myProfileUpdateRequest;
use App\Http\Controllers\Controller;
use App\User;


class MyProfile extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
        return view('admin.users.my-profile');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
        return view('admin.users.my-profile-edit');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(myProfileUpdateRequest $request)
    {
        
        if($request->hasFile('picture'))
        {
            if($request->file('picture')->isValid())
            {

                if(Storage::has(User::find(auth()->user()->id)->user_photo))
                {
                    
                    Storage::delete(User::find(auth()->user()->id)->user_photo);
                    
                }
                
                $photo  = date('Ymdhis').'.'.$request->file('picture')->getClientOriginalExtension();
                
                if($request->file('picture')->move(public_path().'/img/users/', $photo))
                {
                    
                    $request['user_photo'] = '/public/img/users/'.$photo;
                    
                }
                
            }
                        
        }
        
        $request['name'] = $request->input('firstname')." ".$request->input('lastname');
        
        if(User::find(auth()->user()->id)->update($request->all()))
        {
            
            return redirect(action('MyProfile@show'))->withErrors('Profile updated successfully.');
            
        } else{
            
            return back()->withErrors('Failed to update Profile.')->withInput();
            
        }
        
        
    }
    
    
    /**
    *
    * Get changed password view for the logged in user
    *
    */
    public function changePassword()
    {
        
        return view('admin.users.change-password');
        
    }
    
    
    /**
     *
     * Update password of the loggedin user
     *
     */
    public function updatePassword(Request $request)
    {
            
        if($request->input('newpass') == $request->input('repeatpass'))
        {
            
            if( Auth::attempt([ 'email'=> auth()->user()->email, 'password'=>$request->input('oldpass') ]))
            {
                
                if(\DB::table('users')->where('id',auth()->user()->id)->update(['password'=>bcrypt($request->input('newpass'))]))
                {
                    
                    return back()->withErrors('Password updated successfully.');
                    
                } else{
                    
                    return back()->withErrors('Failed to update password.')->withInput();
                    
                }
                
            } else{
                
                return back()->withErrors('Current password did not match.');
                
            }
            
        } else{
                
            return back()->withErrors('New Password and Repeat Password did not match.');
            
        }
            
        
        
        
    }
    
    
    
}
