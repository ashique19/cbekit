<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;

use App\Http\Controllers\Controller;
use App\User;
use Storage;


class Users extends Controller
{
    
    private $index = [
        'list' => [
            'Full name' => 'name',
            'Email' => 'email',
            'Phone' => 'contact'
        ],
        'search' => [
            'Full name' => 'name',
            'Email' => 'email',
            'Phone' => 'contact',
            'From' => 'from',
            'To' => 'to'
        ]
    ];
    
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        return view( 'admin.users.index', [ 'users' => User::latest()->paginate(30) ]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
        return view('admin.users.create');
    
    }
    
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UserCreateRequest $request)
    {
        
        if($request->hasFile('picture'))
        {
            if($request->file('picture')->isValid())
            {

                $photo  = date('Ymdhis').'.'.$request->file('picture')->getClientOriginalExtension();
                
                if($request->file('picture')->move(public_path().'/img/users/', $photo))
                {
                    
                    $request['user_photo'] = '/public/img/users/'.$photo;
                    
                }
                
            }
                        
        }

        $request['name'] = $request->input('firstname')." ".$request->input('lastname');
        
        if(User::create($request->all()))
        {
            
            return redirect(action('Users@index'));
            
        } else
        {
            
            return back()->withErrors('Failed to process request.')->withInput();
            
        }
        
    
    }
    
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
        return view('admin.users.show', ['user'=>User::find($id)]);
        
    }
    
    
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        
        return view('admin.users.edit', ['user'=>User::find($id) , 'roles'=> \App\Role::pluck('name','id') ]);
        
    }
    
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
        if( 
            
            User::where( ['id' => $id, 'email' => $request->email] )->count() == 1
            
            ||
            
            User::where( 'id', '!=', $id )->where( 'email', $request->email )->count() == 0
        
        )
        {
            
            
            if(!$request->input('password')) unset($request['password']);
            
            $request['name'] = $request->input('firstname')." ".$request->input('lastname');
            
            if($request->hasFile('picture'))
            {
                if($request->file('picture')->isValid())
                {
    
                    if(Storage::has(User::find($id)->user_photo))
                    {
                        
                        Storage::delete(User::find($id)->user_photo);
                        
                    }
                    
                    $photo  = date('Ymdhis').'.'.$request->file('picture')->getClientOriginalExtension();
                    
                    if($request->file('picture')->move(public_path().'/img/users/', $photo))
                    {
                        
                        $request['user_photo'] = '/public/img/users/'.$photo;
                        
                    }
                    
                }
                            
            }
            
            if(User::find($id)->update($request->all()))
            {
            
                return back()->withErrors('Request processed successfully');
            
            } else{
                
                return back()->withErrors('Failed to update record. Please retry.');
                
            }
            
        } else{
            
            return back()->withErrors('Email address is already in use. Please try another one.');
            
        }
        
        
    }
    
    
    
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        
        /**
        *
        *
        *   If User is found, remove it.
        * 
        * 
        */
         
        if(User::find($request->id)->delete())
        {
            
            return back()->withErrors('Success');
            
        } else{
            
            return back()->withErrors('Failed to delete the user');
            
        }
        
        
        
    }
    
    
    /**
     * Ajaxified search for user
     * 
     * @return Array of users
    */
    public function ajaxSearch($param)
    {
        
        return User::search($param)->select('id', 'name as text')->take(20)->get()->toArray();
        
    }
    
    
    
}
